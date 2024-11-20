<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\UnitService;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function __construct(
        private readonly ItemService $itemService,
        private readonly UnitService $unitService,
        private readonly CategoryService $categoryService,
    ) {}

    public function show(string $id)
    {
        $item = Item::withTrashed()->find($id);
        $item->load([
            'allStock.variation',
            'allStock.warehouse'
        ]);
        
        $item->setting = get_settings();

        $stocksGroupedByWarehouse = $item->allStock->groupBy('warehouse_id');
        return response()->json([
            'category' => $item->category->name ?? '', 
            'units' => $item->unit ?? '',
            'item' => $item,
            'stocks' => $stocksGroupedByWarehouse,
            'weightUnit' => get_settings('track_weight') ? get_settings('weight_unit') : $item->unit->code,
        ]);
    }

    public function search(Request $request)
    {
        if ($request->input('id')) {
            return response()->json(Item::with('variations')->whereId($request->input('id'))->get());
        }
        return response()->json(Item::with('variations')->search($request->input('q', ''))->take(10)->get());
    }
}
