<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Warehouse;
use App\Models\Adjustment;
use Illuminate\Http\Request;
use App\Services\UnitService;
use App\Actions\Tec\PrepareOrder;
use App\Http\Requests\AdjustmentRequest;
use App\Http\Resources\AdjustmentResource;
use App\Models\Item;
use App\Services\WarehouseService;

class AdjustmentController extends Controller
{
    public function __construct(
        protected UnitService $unitService,
        protected WarehouseService $warehouseService,
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'   => $request->input('trashed',Item::WITH_TRASH),
            'draft'     => $request->input('draft'),
        ];
        
        $adjustments = Adjustment::filters($filters)->with(['warehouse', 'user'])
                            ->orderBy('id' , 'desc')
                            ->paginate();
        $units = $this->unitService->getModel()->with('subunits')->get();
        if ($request->ajax()) {
            return response()->view('pages.adjustment.table_list_adjustment', [
                'adjustments'   => $adjustments,
                'filters'       => $filters,
                'units'         => $units
            ]); 
        }

        return view('pages.adjustment.index', [
            'adjustments'   => $adjustments,
            'filters'       => $filters,
            'units'         => $units
        ]);
    }

    public function create()
    {
        return view('pages.adjustment.create', [
            'warehouses' => Warehouse::ofAccount()->active()->get(),
            'units'      => $this->unitService->getModel()->with('subunits')->get(),
        ]);
    }

    public function store(AdjustmentRequest $request)
    {
        $data = $request->validated();
        $adjustment = (new PrepareOrder($data, $request->file('attachments'), new Adjustment()))->process()->save();
        event(new \App\Events\AdjustmentEvent($adjustment, 'created'));
        return redirect()->route('adjustments.index')->with('success', __('messages.create.success'));
    }

    public function show(Adjustment $adjustment, Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'   => $request->input('trashed'),
            'draft'     => $request->input('draft'),
            'prv'       => true,
        ];
        $adjustment->load(['items.variations', 'items.item:id,code,name,track_quantity,track_weight', 'warehouse', 'items.unit:id,code,name', 'user:id,name:username', 'attachments']);
        $adjustment->setting = get_settings();
        
        return $request->json ? $adjustment : view('pages.adjustment.detail', [
            'filters'    => $filters,
            'adjustment' => new AdjustmentResource($adjustment),
            'setting'    => get_settings(),
        ]);
    }


    public function edit(Adjustment $adjustment, Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'   => $request->input('trashed'),
            'draft'     => $request->input('draft'),
            'prv'       => $request->input('prv', false),
        ];
        $adjustment->load(['items.variations', 'items.item.variations', 'attachments']);
        $warehouses = $this->warehouseService->getActiveOfAccount();
        $units = $this->unitService->getModel()->with('subunits')->get();

        return view('pages.adjustment.edit', [
            'warehouses'    => $warehouses,
            'units'         => $units,
            'adjustment'    => new AdjustmentResource($adjustment),
            'filters'       => $filters
        ]);
    }

    public function update(Adjustment $adjustment, AdjustmentRequest $request)
    {
        $data = $request->validated();
        $data['draft'] = $data['draft'] ?? 0;
        $original = $adjustment->load(['items.item', 'items.unit', 'items.variations'])->replicate();
        $adjustment = (new PrepareOrder($data, $request->file('attachments'), $adjustment))->process()->save();
        event(new \App\Events\AdjustmentEvent($adjustment, 'updated', $original));
        return redirect()->route('adjustments.index')->with('success', __('messages.update.success'));
    }

    public function destroy(Adjustment $adjustment)
    {
        $adjustment->load(['items.item', 'items.unit', 'items.variations']);
        if ($adjustment->del()) {
            event(new \App\Events\AdjustmentEvent($adjustment, 'deleted'));
            return redirect()->route('adjustments.index')->with('success', __('messages.soft_delete.success'));
        }

        return redirect()->route('adjustments.index')->with('error', __('messages.soft_delete.exception'));
    }

    public function destroyPermanently(Adjustment $adjustment)
    {
        $adjustment->load(['items.item', 'items.unit', 'items.variations']);
        if ($adjustment->delP()) {
            event(new \App\Events\AdjustmentEvent($adjustment, 'deleted'));
            return redirect()->route('adjustments.index')->with('success', __('messages.permanent_delete.success'));
        }
        
        return redirect()->route('adjustments.index')->with('error', __('messages.permanent_delete.error'));
    }

    public function restore(Adjustment $adjustment)
    {
        $adjustment->restore();
        $adjustment->items->each->restore();
        event(new \App\Events\AdjustmentEvent($adjustment, 'restored'));
        return back()->with('success', __('messages.restore.success'));
    }
}
