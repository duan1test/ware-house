<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 20%;">{{ __('attributes.contact.name') }}</th>
                <th style="width: 20%;">{{ __('attributes.user.email') }}</th>
                <th style="width: 20%;">{{ __('attributes.user.phone') }}</th>
                <th style="width: 30%;">{{ __('attributes.item.details') }}</th>
                <th style="width: 10%;"></th>
            </tr>
        </thead>
        <tbody>
            @if ($contacts->total() > 0)
                @foreach ($contacts as $contact)
                    <tr>
                        <td>
                            {{ $contact->name }}
                            @if ($contact->deleted_at)     
                            <span><i class="bx bx-trash text-danger"></i></span>
                            @endif
                        </td>
                        <td>{{ $contact->email }}</td>
                        <td>
                            {{ $contact->phone ?? ''}}
                        </td>
                        <td>
                            <div class="max-w-[400px] whitespace-normal text-black line-clamp-3">
                                <p class="w-full">{{ $contact->details ?? ''}}</p>
                            </div>
                        </td>
                        <td class="text-end">
                             <a title="{{__('common.edit')}}" class="btn hover-color hover-warning" href="{{ route('contacts.edit', ['contact'=>$contact->id, ...$filters]) }}">
                                <i class='bx bx-edit-alt' ></i>
                            </a> 
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="5">{{ __('common.no_data') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


<div class="row justify-content-between align-items-center">
    @if ($contacts->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $contacts->firstItem(),
                'to' => $contacts->lastItem(),
                'total' => $contacts->total(),
            ]) }}
        </div>
    @endif

    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $contacts->links() }}
        </div>
    </div>
</div>
@push('js')
    <script>
        function redirect(url) {
            location.href = url;
        }
    </script>
@endpush
