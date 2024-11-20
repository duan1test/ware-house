<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Checkin;
use App\Models\Contact;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Services\UnitService;
use App\Actions\Tec\PrepareOrder;
use App\Http\Requests\CheckinRequest;
use App\Http\Resources\CheckinResource;
use App\Models\Item;

class CheckinController extends Controller
{
    public function __construct(
        protected UnitService $unitService,
    ) {}
    
    public function index(Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'   => $request->input('trashed',Item::WITH_TRASH),
            'draft'     => $request->input('draft'),
        ];

        $checkins = Checkin::with(['contact', 'warehouse', 'user'])->filters($filters)
                            ->orderBy('id' , 'desc')
                            ->paginate();
        $units = $this->unitService->getModel()->with('subunits')->get();
        if ($request->ajax()) {
            return response()->view('pages.checkin.table_list_checkin', [
                'checkins'      => $checkins,
                'filters'       => $filters,
                'units'         => $units
            ]); 
        }

        return view('pages.checkin.index', [
            'checkins'      => $checkins,
            'filters'       => $filters,
            'units'         => $units
        ]);
    }

    public function create()
    {
        return view('pages.checkin.create', [
            'warehouses' => Warehouse::ofAccount()->active()->get(),
            'units'      => $this->unitService->getModel()->with('subunits')->get(),
            'contacts'   => Contact::ofAccount()->get(),
        ]);
    }

    public function store(CheckinRequest $request)
    {
        $data = $request->validated();
        $checkin = (new PrepareOrder($data, $request->file('attachments'), new Checkin()))->process()->save();
        event(new \App\Events\CheckinEvent($checkin, 'created'));
        return redirect()->route('checkins.index')->with('success', __('messages.create.success'));
    }

    public function show(Checkin $checkin, Request $request)
    {
        $filters = [
            'q'         => $request->input('q'),
            'trashed'   => $request->input('trashed'),
            'drafts'    => $request->input('drafts'),
            'prv'       => true,
        ];
        $checkin->load([
            'items.variations', 
            'items.item:id,code,name,track_quantity,track_weight', 
            'warehouse','items.unit:id,code,name',
            'user:id,name:username','contact', 'attachments'
        ]);
        $checkin->setting = get_settings();
        
        return $request->json ? $checkin : view('pages.checkin.detail', [
            'checkin' => new CheckinResource($checkin), 
            'filters' => $filters,
            'setting' => get_settings(),
        ]);
    
    }

    public function edit(Checkin $checkin, Request $request)
    {
        $filters = [
            'q'         => $request->input('q'),
            'trashed'   => $request->input('trashed'),
            'drafts'    => $request->input('drafts'),
            'prv'       => $request->input('prv', false),
        ];
        $checkin->load('items','attachments');
        return view('pages.checkin.edit', [
            'checkin'    => new CheckinResource($checkin),
            'warehouses' => Warehouse::ofAccount()->active()->get(),
            'units'      => $this->unitService->getModel()->with('subunits')->get(),
            'contacts'   => Contact::ofAccount()->get(),
            'filters'   => $filters
        ]);
    }

    public function update(Checkin $checkin, CheckinRequest $request)
    {
        $data = $request->validated();
        $data['draft'] = $data['draft'] ?? 0;
        $original = $checkin->load(['items.item','items.unit', 'items.variations'])->replicate();
        $checkin = (new PrepareOrder($data, $request->file('attachments'), $checkin))->process()->save();
        event(new \App\Events\CheckinEvent($checkin, 'updated', $original));
        return redirect()->route('checkins.index')->with('success', __('messages.update.success'));
    }

    public function destroy(Checkin $checkin)
    {
        $checkin->load(['items.item', 'items.unit', 'items.variations']);
        if ($checkin->del()) {
            event(new \App\Events\CheckinEvent($checkin, 'deleted'));
            return redirect()->route('checkins.index')->with('success', __('messages.soft_delete.success'));
        }
        return redirect()->route('checkins.index')->with('error', __('messages.soft_delete.exception'));
    }

    public function destroyPermanently(Checkin $checkin)
    {
        $checkin->load(['items.item', 'items.unit', 'items.variations']);
        if ($checkin->delP()) {
            event(new \App\Events\CheckinEvent($checkin, 'deleted'));
            return redirect()->route('checkins.index')->with('success', __('messages.permanent_delete.success'));
        }
        return redirect()->route('checkins.index')->with('error', __('messages.soft_delete.exception'));
    }

    public function restore(Checkin $checkin){
        $checkin->restore();
        $checkin->items->each->restore();
        event(new \App\Events\CheckinEvent($checkin, 'restored'));
        return redirect()->route('checkins.index')->with('success', __('messages.restore.success'));
    }
}
