<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\StoreUnitRequest;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct(
        protected UnitService $unitService,
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'    => $request->input('trashed', Unit::WITH_TRASH),
        ];
        $units = $this->unitService->getModel()->filters($filters)
                                ->orderBy('id' , 'desc')
                                ->paginate();
        $parents = Unit::Base()->get();
        if ($request->ajax()) {
            return response()->view('pages.unit.table_list_unit', compact('units','filters')); 
        }

        return view('pages.unit.index', [
            'units'    => $units,
            'allUnits' => $parents,
            'filters'  => $filters
        ]);
    }

    public function create()
    {
        return view('pages.unit.create', [
            'units'      => Unit::Base()->get(),
        ]);
    }

    public function store(StoreUnitRequest $request)
    {
        Unit::create($request->validated());

        return redirect()->route('units.index')->with('success', __('messages.create.success'));
    }

    public function edit(Request $request, Unit $unit)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'    => $request->input('trashed',Unit::WITH_TRASH),
        ];
        $units = Unit::where('id', '!=', $unit->id)->base()->get();
        return view('pages.unit.edit', compact('unit', 'units', 'filters'));
    }

    public function update(StoreUnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return redirect()->route('units.index')->with('success', __('messages.update.success'));
    }

    public function destroy(Unit $unit)
    {
        if($unit->del()){
            return redirect()->route('units.index')->with('success', __('messages.soft_delete.success'));
        }

        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
    }

    public function destroyPermanently(Unit $unit)
    {
        if($unit->delP()){
            return redirect()->route('units.index')->with('success', __('messages.permanent_delete.success'));
        }
        
        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
    }

    public function restore(Unit $unit)
    {
        $unit->restore();

        return redirect()->route('units.index')->with('success', __('messages.restore.success'));
    }
}
