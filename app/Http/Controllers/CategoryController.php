<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'   => $request->input('trashed',Category::WITH_TRASH),
            'parents'   => $request->input('parent_id')
        ];
        $categories = Category::filters($filters)
                                ->orderBy('id' , 'desc')
                                ->paginate();
        $parents = Category::onlyParents()->get();
        if ($request->ajax()) {
            return response()->view('pages.category.table_list_category', compact('categories','filters')); 
        }

        return view('pages.category.index', [
            'categories'    => $categories,
            'allCategories' => $parents,
            'filters'       => $filters
        ]);
    }

    public function create(Category $category) {
        $categories = Category::onlyParents()->get();

        return view('pages.category.create', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();
        Category::create($validatedData);

        return redirect()->route('categories.index')->with('success', __('messages.create.success'));
    }

    public function show(Request $request, Category $category)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'    => $request->input('trashed'),
            'parents'   => $request->input('parent_id')
        ];
        $categories = Category::where('id', '!=', $category->id)->onlyParents()->get();
        return view('pages.category.edit', compact('category', 'categories','filters'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validated();
        $category->update($validatedData);

        return redirect()->route('categories.index')->with('success', __('messages.update.success'));
    }

    public function destroy(Category $category)
    {
        if($category->del()){
            return redirect()->route('categories.index')->with('success', __('messages.soft_delete.success'));
        }

        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
    }

    public function destroyPermanently(Category $category)
    {
        if($category->delP()){
            return redirect()->route('categories.index')->with('success', __('messages.permanent_delete.success'));
        }
        
        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
    }

    public function restore(Category $category)
    {
        $category->restore();

        return redirect()->route('categories.index')->with('success', __('messages.restore.success'));
    }
}
