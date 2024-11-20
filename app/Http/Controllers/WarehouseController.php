<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Services\WarehouseService;

class WarehouseController extends Controller
{
    public function __construct(
        private WarehouseService $warehouseService,
    ) 
    {

    }
    public function index(Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'   => $request->input('trashed',Warehouse::WITH_TRASH)
        ];
        
        $warehouses = Warehouse::filters($filters)
                                ->orderBy('id', 'desc')
                                ->paginate();
                                
        return view('pages.warehouse.index', compact('warehouses','filters'));
    }

    public function show(Request $request, Warehouse $warehouse) 
    {   
        $filters = [
            'search' => $request->input('q'),
            'trashed' => $request->input('trashed',Warehouse::WITH_TRASH)
        ];
        return view('pages.warehouse.edit', compact('warehouse','filters'));
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        $validatedData = $request->validated();
        $validatedData['active'] = $request->boolean('status');
        $this->warehouseService->update($validatedData, $warehouse);
    
        return redirect()->route('warehouses.index')->with('success', __('messages.update.success'));
    }
    
    public function create() {
        return view('pages.warehouse.create');
    }

    public function store(StoreWarehouseRequest $request) 
    {
        $validatedData = $request->validated();
        $this->warehouseService->store($validatedData);
        
        return redirect()->route('warehouses.index')->with('success', __('messages.create.success'));
    }

    public function destroy(Warehouse $warehouse)
    {
        if ($warehouse->del()) {
            return redirect()->route('warehouses.index')->with('success', __('messages.soft_delete.success'));
        }
        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
       
    }

    public function restore(Warehouse $warehouse)
    {
        $warehouse->restore();

        return redirect()->route('warehouses.index')->with('success', __('messages.restore.success'));
    }

    public function destroyPermanently(Warehouse $warehouse) 
    {        
        if ($warehouse->delP()) {
            return redirect()->route('warehouses.index')->with('success', __('messages.permanent_delete.success'));
        }
        return redirect()->back()->with('error', __('messages.soft_delete.exception'));

    }
}
