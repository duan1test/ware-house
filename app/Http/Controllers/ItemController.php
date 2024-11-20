<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\UnitService;
use App\Services\CategoryService;
use App\Http\Requests\Item\CreateItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Models\Item;

class ItemController extends Controller
{
    public function __construct(
        private readonly ItemService $itemService,
        private readonly UnitService $unitService,
        private readonly CategoryService $categoryService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Item $item,Request $request)
    {
        $filters = [
            'search' => $request->input('q', ''),
            'trashed' => $request->input('trashed', Item::WITH_TRASH),
        ];

        $statusFilters = Item::trashFilters([
            'labelOnly'     => __('common.items.only_trashed'),
            'labelWith'     => __('common.items.with_trashed'),
            'labelNot'      => __('common.items.not_trashed'),
        ]);
        $items = $this->itemService->getAll($filters, relations: ['unit', 'category', 'stock.warehouse']);
        if ($request->ajax()) {
            return response()->view('pages.item.table_list', compact('items', 'filters'));
        }
        return view('pages.item.index', compact('items', 'filters', 'statusFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barcodes = $this->getBarcodes();
        $categories = $this->categoryService->getAll();
        $units = $this->unitService->getBaseUnit();

        return view('pages.item.create', compact('categories', 'units', 'barcodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateItemRequest $request)
    {
        $this->itemService->store($request->validated());

        return to_route('items.index')->with('success', __('common.items.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item, Request $request)
    {
        $filters = [
            'search'    => $request->input('q', ''),
            'trashed'   => $request->input('trashed', Item::WITH_TRASH),
        ];
        
        $item->load([
            'allStock.variation',
            'allStock.warehouse'
        ]);
        $stocksGroupedByWarehouse = $item->allStock->groupBy('warehouse_id');
        $weightUnit = get_settings('track_weight') ? get_settings('weight_unit') : $item->unit->code;

        return view('pages.item.detail', compact('stocksGroupedByWarehouse', 'item', 'filters', 'weightUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item, Request $request)
    {
        $filters = [
            'search'    => $request->input('q', ''),
            'trashed'   => $request->input('trashed', Item::WITHOUT_TRASH),
            'prv'       => $request->input('prv', false)
        ];
        $item->load('categories:id,code,name');
        $barcodes = $this->getBarcodes();
        $categories = $this->categoryService->getAll();
        $units = $this->unitService->getBaseUnit();
        
        return view('pages.item.edit', compact('categories', 'units', 'barcodes', 'item', 'filters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $this->itemService->update($request->validated(), $item);

        return to_route('items.index')->with('success', __('common.items.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        if($this->itemService->destroy(item: $item, forceDelete: request()->boolean('force_delete'))){
            return to_route('items.index')->with('success', __('common.items.deleted'));
        }
        
        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
        
    }

    public function destroyPermanently(Item $item)
    {
        if($item->delP()){
            return redirect()->route('items.index')->with('success', __('messages.permanent_delete.success'));
        }
        
        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
    }

    public function restore(Item $item) 
    {
        $item->restore();

        return redirect()->route('items.index')->with('success', __('messages.restore.success'));
    }

    public function search(Request $request)
    {
        $filters = [
            'search' => $request->input('q', ''),
            'trashed' => $request->input('trashed', Item::WITH_TRASH),
        ];
        $items = $this->itemService->getAll($filters);
        
        return response()->json($items);
    }

    private function getBarcodes(): array
    {
        return [
            (object)[
                'id' => 'CODE128',
                'name' => 'CODE128',
            ],
            (object)[
                'id' => 'CODE39',
                'name' => 'CODE39',
            ],
            (object)[
                'id' => 'EAN5',
                'name' => 'EAN-5',
            ],
            (object)[
                'id' => 'EAN8',
                'name' => 'EAN-8',
            ],
            (object)[
                'id' => 'EAN13',
                'name' => 'EAN-13',
            ],
            (object)[
                'id' => 'UPC',
                'name' => 'UPC-A',
            ]
        ];
    }

    public function trail(Item $item, Request $request) {
        $filters = (object)[
            'search' => $request->input('q', ''),
            'trashed' => $request->input('trashed', Item::WITHOUT_TRASH),
        ];
        $trails = $item->stockTrails()
                ->orderBy('id', 'desc')
                ->paginate();
                
        return view('pages.item.trail', compact('item', 'trails', 'filters'));
    }
}
