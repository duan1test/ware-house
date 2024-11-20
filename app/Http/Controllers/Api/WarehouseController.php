<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('q'),
            'trashed' => $request->input('trashed',Warehouse::WITH_TRASH)
        ];
        $warehouses = Warehouse::filters($filters)
                                ->orderBy('id', 'desc')
                                ->paginate();

        return response()->view('pages.warehouse.table_list_warehouse', compact('warehouses','filters'));
    }
}
