<div class="table-responsive">
    <table class="table @if ($categories->total() > 0)  table-hover @endif" id="category-table">
        <thead>
          <tr>
              <th scope="col">{{ __('attributes.category.code') }}</th>
            <th scope="col">{{ __('attributes.category.name') }}</th>
            <th scope="col">{{ __('attributes.category.parent_id') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @if ($categories->total() > 0)        
                @foreach ($categories as $category)    
                    <tr>
                        <td scope="row">
                            {{ $category->code }}
                            @if ($category->deleted_at)     
                                <span><i class="bx bx-trash text-danger"></i></span>
                            @endif
                        </td>
                        <td>{{ $category->name }}</td>
                        <td> {{ $category->parentCategory ? $category->parentCategory->name . ' (' . $category->parentCategory->code . ')' : '' }}</td> 
                        <td class="text-center data-link">
                            <a title="{{__('common.edit')}}" class="btn hover-color hover-warning" href="{{ route('categories.show', ['category'=>$category->id, ...$filters]) }}">
                                <i class='bx bx-edit-alt'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center" style="cursor: auto;">{{ __('common.no_data') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="row justify-content-between align-items-center">
    @if ($categories->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem(),
                'total' => $categories->total(),
            ]) }}
        </div>
    @endif
    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $categories->links() }}
        </div>
    </div>
</div>