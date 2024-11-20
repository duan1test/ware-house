<?php

namespace App\Http\Controllers;

use App\Services\UnitService;
use App\Http\Resources\{AdjustmentCollection, CheckinCollection, CheckoutCollection, TransferCollection};
use App\Models\{Category, Transfer, User, Warehouse, Item, Contact, Checkin, Checkout, Adjustment, Unit, Role};
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        private readonly UnitService $unitService,
    ) {}

    public function index()
    {
        $data = Item::selectRaw('COUNT(*) as items')->without('unit')
        ->addSelect(['contacts' => Contact::selectRaw('COUNT(*) as contacts')])
        ->addSelect(['categories' => Category::selectRaw('COUNT(*) as categories')])
        ->addSelect(['warehouses' => Warehouse::selectRaw('COUNT(*) as warehouses')])
        ->addSelect(['checkins' => Checkin::selectRaw('COUNT(*) as checkins')])
        ->addSelect(['checkouts' => Checkout::selectRaw('COUNT(*) as checkouts')])
        ->addSelect(['transfers' => Transfer::selectRaw('COUNT(*) as transfers')])
        ->addSelect(['adjustments' => Adjustment::selectRaw('COUNT(*) as adjustments')])
        ->addSelect(['units' => Unit::selectRaw('COUNT(*) as units')])
        ->addSelect(['users' => User::selectRaw('COUNT(*) as users')])
        ->addSelect(['roles' => Role::selectRaw('COUNT(*) as roles')])
        ->first();
        return view('pages.report.index', ['data' => $data->getAttributes()]);
    }

    public function transfer(Request $request)
    {
        $filters = $request->all('start_date', 'end_date', 'start_created_at', 'end_created_at', 'reference', 'from_warehouse_id', 'user_id', 'to_warehouse_id', 'draft', 'trashed', 'category_id');
        $units = $this->unitService->getModel()->with('subunits')->get();
        return view('pages.report.transfer', [
            'filters'    => $filters,
            'users'      => User::ofAccount()->get(),
            'categories' => Category::ofAccount()->get(),
            'warehouses' => Warehouse::ofAccount()->active()->get(),
            'transfers'  => new TransferCollection(
                Transfer::with(['fromWarehouse', 'toWarehouse', 'user'])->reportFilter($filters)->orderByDesc('id')->paginate()->withQueryString()
            ),
            'units'      => $units,
        ]);
    }

    public function adjustment(Request $request)
    {
        $filters = $request->all('start_date', 'end_date', 'start_created_at', 'end_created_at', 'reference', 'user_id', 'warehouse_id', 'draft', 'trashed', 'category_id');

        return view('pages.report.adjustment', [
            'filters'     => $filters,
            'users'       => User::ofAccount()->get(),
            'categories'  => Category::ofAccount()->get(),
            'warehouses'  => Warehouse::ofAccount()->active()->get(),
            'adjustments' => new AdjustmentCollection(
                Adjustment::with(['warehouse', 'user'])->reportFilter($filters)->orderByDesc('id')->paginate()->withQueryString()
            ),
            'units'      => $this->unitService->getModel()->with('subunits')->get(),
        ]);
    }

    public function checkin(Request $request)
    {
        $filters = $request->all('start_date', 'end_date', 'start_created_at', 'end_created_at', 'reference', 'contact_id', 'user_id', 'warehouse_id', 'draft', 'trashed', 'category_id');

        return view('pages.report.checkin', [
            'filters'    => $filters,
            'users'      => User::ofAccount()->get(),
            'contacts'   => Contact::ofAccount()->get(),
            'categories' => Category::ofAccount()->get(),
            'warehouses' => Warehouse::ofAccount()->active()->get(),
            'checkins'   => new CheckinCollection(
                Checkin::with(['contact', 'warehouse', 'user'])->reportFilter($filters)->orderByDesc('id')->paginate()->withQueryString()
            ),
            'units'      => $this->unitService->getModel()->with('subunits')->get(),
        ]);
    }

    public function checkout(Request $request)
    {
        $filters = $request->all('start_date', 'end_date', 'start_created_at', 'end_created_at', 'reference', 'contact_id', 'user_id', 'warehouse_id', 'draft', 'trashed', 'category_id');

        return view('pages.report.checkout', [
            'filters'    => $filters,
            'users'      => User::ofAccount()->get(),
            'contacts'   => Contact::ofAccount()->get(),
            'categories' => Category::ofAccount()->get(),
            'warehouses' => Warehouse::ofAccount()->active()->get(),
            'checkouts'  => new CheckoutCollection(
                Checkout::with(['contact', 'warehouse', 'user'])->reportFilter($filters)->orderByDesc('id')->paginate()->withQueryString()
            ),
            'units'      => $this->unitService->getModel()->with('subunits')->get(),
        ]);
    }
}
