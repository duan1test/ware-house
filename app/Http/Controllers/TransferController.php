<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Transfer;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\UnitService;
use App\Actions\Tec\PrepareOrder;
use App\Services\WarehouseService;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\TransferResource;

class TransferController extends Controller
{
    public function __construct(
        private readonly ItemService $itemService,
        private readonly UnitService $unitService,
        private readonly WarehouseService $warehouseService,
    ) {}
    public function index(Request $request)
    {
        $filters = [
            'q'         => $request->input('q'),
            'trashed'   => $request->input('trashed',Transfer::WITH_TRASH),
            'draft'    => $request->input('draft','all'),
        ];
        $transfers = Transfer::filters($filters)
                            ->orderBy('id' , 'desc')
                            ->paginate();
        $units = $this->unitService->getModel()->with('subunits')->get();
        if ($request->ajax()) {
            return response()->view('pages.transfer.table_list_transfer', [
                'transfers' => $transfers,
                'filters'   => $filters,
                'units'      => $units
            ]); 
        }

        return view('pages.transfer.index', [
            'transfers' => $transfers,
            'filters'   => $filters,
            'units'      => $units
        ]);
    }

    public function create(Request $request) {
        $warehouses = $this->warehouseService->getActiveOfAccount();
        $units = $this->unitService->getModel()->with('subunits')->get();

        return view('pages.transfer.create', compact('warehouses', 'units'));
    }

    public function store(TransferRequest $request)
    {
        $data = $request->validated();
        $transfer = (new PrepareOrder($data, $request->file('attachments'), new Transfer()))->process()->save();
        event(new \App\Events\TransferEvent($transfer, 'created'));
        return redirect()->route('transfers.index')->with('success', __('messages.create.success'));
    }

    public function show(Transfer $transfer, Request $request)
    {
        $filters = [
            'q'         => $request->input('q'),
            'trashed'   => $request->input('trashed'),
            'drafts'    => $request->input('drafts'),
            'prv'       => true,
        ];
        $transfer->load([
            'items.variations', 
            'items.item:id,code,name,track_quantity,track_weight', 
            'fromWarehouse', 'toWarehouse', 'items.unit:id,code,name',
            'user:id,name:username', 'attachments'
        ]);
        $transfer->setting = get_settings();
        
        return $request->json ? $transfer : view('pages.transfer.detail', [
            'transfer' => new TransferResource($transfer), 
            'filters' => $filters,
            'setting' => get_settings(),
        ]);
    }

    public function edit(Transfer $transfer, Request $request)
    {
        $transfer->load(['items.variations', 'items.item', 'fromWarehouse', 'toWarehouse', 'items.unit:id,code,name', 'user:id,name:username', 'attachments']);
        $warehouses = $this->warehouseService->getActiveOfAccount();
        $units = $this->unitService->getModel()->with('subunits')->get();
        $filters = [
            'q'         => $request->input('q'),
            'trashed'   => $request->input('trashed'),
            'drafts'    => $request->input('drafts'),
            'prv'       => $request->input('prv', false),
        ];

        return view('pages.transfer.edit', [
            'warehouses' => $warehouses,
            'units' => $units,
            'transfer' => new TransferResource($transfer),
            'filters' => $filters
        ]);
    }

    public function update(Transfer $transfer, TransferRequest $request)
    {
        $data = $request->validated();
        $data['draft'] = $data['draft'] ?? 0;
        $original = $transfer->load(['items.item', 'items.unit', 'items.variations'])->replicate();
        $transfer = (new PrepareOrder($data, $request->file('attachments'), $transfer))->process()->save();
        event(new \App\Events\TransferEvent($transfer, 'updated', $original));
        return redirect()->route('transfers.index')->with('success', __('messages.update.success'));
    }

    public function restore(Transfer $transfer)
    {
        $transfer->restore();
        $transfer->items->each->restore();
        event(new \App\Events\TransferEvent($transfer, 'restored'));
        return redirect()->route('transfers.index')->with('success', __('messages.restore.success'));
    }

    public function destroy(Transfer $transfer)
    {
        $transfer->load(['items.item', 'items.unit', 'items.variations']);
        if ($transfer->del()) {
            event(new \App\Events\TransferEvent($transfer, 'deleted'));
            return redirect()->route('transfers.index')->with('success', __('messages.soft_delete.success'));
        }
        return redirect()->route('transfers.index')->with('error', __('messages.soft_delete.exception'));
    }

    public function destroyPermanently(Transfer $transfer)
    {
        $transfer->load(['items.item', 'items.unit', 'items.variations']);
        if ($transfer->delP()) {
            event(new \App\Events\TransferEvent($transfer, 'deleted'));
            return redirect()->route('transfers.index')->with('success', __('messages.permanent_delete.success'));
        }
        return redirect()->route('transfers.index')->with('error', __('messages.soft_delete.exception'));
    }
}
