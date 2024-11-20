<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Contact;
use App\Models\Checkout;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Actions\Tec\PrepareOrder;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Services\UnitService;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected UnitService $unitService,
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'   => $request->input('trashed'),
            'draft'     => $request->input('draft'),
        ];

        $checkouts = Checkout::with(['contact', 'warehouse', 'user'])->filters($filters)
                            ->orderBy('id' , 'desc')
                            ->paginate();
        $units = $this->unitService->getModel()->with('subunits')->get();
        if ($request->ajax()) {
            return response()->view('pages.checkout.table_list_checkout', [
                'checkouts'     => $checkouts,
                'filters'       => $filters,
                'units'         => $units
            ]); 
        }

        return view('pages.checkout.index', [
            'checkouts'     => $checkouts,
            'filters'       => $filters,
            'units'         => $units
        ]);
    }

    public function create()
    {
        return view('pages.checkout.create', [
            'warehouses' => Warehouse::ofAccount()->active()->get(),
            'units'      => $this->unitService->getModel()->with('subunits')->get(),
            'contacts'   => Contact::ofAccount()->get(),
        ]);
    }

    public function store(CheckoutRequest $request)
    {
        $data = $request->validated();
        $checkout = (new PrepareOrder($data, $request->file('attachments'), new Checkout()))->process()->save();
        event(new \App\Events\CheckoutEvent($checkout, 'created'));
        return redirect()->route('checkouts.index')->with('success', __('messages.create.success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Checkout $checkout)
    {
        $filters = [
            'q'         => $request->input('q'),
            'trashed'   => $request->input('trashed'),
            'drafts'    => $request->input('drafts'),
            'prv'       => true,
        ];
        $checkout->load([
            'items.variations', 
            'items.item:id,code,name,track_quantity,track_weight', 
            'warehouse','items.unit:id,code,name',
            'user:id,name:username','contact', 'attachments'
        ]);
        $checkout->setting = get_settings();
        
        return $request->json ? $checkout : view('pages.checkout.detail', [
            'checkout' => new CheckoutResource($checkout), 
            'filters' => $filters,
            'setting' => get_settings(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkout $checkout, Request $request)
    {
        $filters = [
            'q'         => $request->input('q'),
            'trashed'   => $request->input('trashed'),
            'drafts'    => $request->input('drafts'),
            'prv'       => $request->input('prv', false),
        ];
        $checkout->load('items','attachments');
        return view('pages.checkout.edit', [
            'checkout'    => new CheckoutResource($checkout),
            'warehouses' => Warehouse::ofAccount()->active()->get(),
            'units'      => $this->unitService->getModel()->with('subunits')->get(),
            'contacts'   => Contact::ofAccount()->get(),
            'filters'   => $filters
        ]);
    }

    public function update(Checkout $checkout, CheckoutRequest $request)
    {
        $data = $request->validated();
        $data['draft'] = $data['draft'] ?? 0;
        $original = $checkout->load(['items.item','items.unit', 'items.variations'])->replicate();
        $checkout = (new PrepareOrder($data, $request->file('attachments'), $checkout))->process()->save();
        event(new \App\Events\CheckoutEvent($checkout, 'updated', $original));
        return redirect()->route('checkouts.index')->with('success', __('messages.update.success'));
    }

    public function destroy(Checkout $checkout)
    {
        $checkout->load(['items.item', 'items.unit', 'items.variations']);
        if ($checkout->del()) {
            event(new \App\Events\CheckoutEvent($checkout, 'deleted'));
            return redirect()->route('checkouts.index')->with('success', __('messages.soft_delete.success'));
        }
        return redirect()->route('checkouts.index')->with('error', __('messages.soft_delete.exception'));
    }

    public function destroyPermanently(Checkout $checkout)
    {
        $checkout->load(['items.item', 'items.unit', 'items.variations']);
        if ($checkout->delP()) {
            event(new \App\Events\CheckoutEvent($checkout, 'deleted'));
            return redirect()->route('checkouts.index')->with('success', __('messages.permanent_delete.success'));
        }
        return redirect()->route('checkouts.index')->with('error', __('messages.soft_delete.exception'));
    }

    public function restore(Checkout $checkout)
    {
        $checkout->restore();
        $checkout->items->each->restore();
        event(new \App\Events\CheckoutEvent($checkout, 'restored'));
        return redirect()->route('checkouts.index')->with('success', __('messages.restore.success'));
    }
}
