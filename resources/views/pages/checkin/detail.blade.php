<x-app-layout>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('checkins.index') }}">{{ __('common.checkin.index') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('common.checkin.detail') }}</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="w-100 d-flex align-items-center">
                    <a href="{{ route('checkins.index', $filters) }}" class="me-2">
                        <i class='bx bx-arrow-back'></i>
                    </a>
                    <h5 class="page-title mt-3 mb-3">{{ __('common.checkin.detail') }} ({{$checkin->reference}})</h5>
                </div>
                <div class="me-2">
                    <a href="#" class="item-detail-edit rounded-circle p-2 event-print" title="{{ __('common.print') }}">
                        <i class="fa-solid fa-print"></i>
                    </a>
                </div>
                <div>
                    <a href="{{ route('checkins.edit', [$checkin->id, ...$filters]) }}" class="item-detail-edit rounded-circle p-2" title="{{ __('common.checkin.edit') }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </div>
            </div>
            
            <div class="card-body overflow-hidden printable">
                @if ($checkin->draft == true)
                    <div class="row page-breadcrumb">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="fa-solid fa-circle-exclamation me-2"></i>
                                {{ __('common.adjustment.draft') }}
                            </div>
                        </div>
                    </div>
                @endif
                @if ($checkin->deleted_at != null)
                    <div class="row page-breadcrumb">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="fa-solid fa-trash-can fa-circle-exclamation me-2"></i>
                                {{ __('attributes.transfer.soft_delete') }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="d-flex flex-column text-end">
                    <span class="font-bold lh-lg">{{ $checkin->warehouse->name }} ({{ $checkin->warehouse->code }})</span>
                    <span class="lh-lg">{{ $checkin->warehouse->address ?? '' }}</span>
                    <span class="lh-lg">{{ $checkin->warehouse->phone ?? '' }}</span>
                    <span class="lh-lg">{{ $checkin->warehouse->email ?? '' }}</span>
                </div>
                <div class="d-flex flex-col justify-content-center align-items-center">
                    <p class="text-xl text-center uppercase font-bold">{{__('common.checkin.title')}}</p>
                    <img class="max-h-[100px]" id="barcode"></img>
                </div>
                <div class="row d-flex flex-row justify-content-center align-items-center mt-4">
                    <div class="col-6 d-flex flex-column text-start">
                        <span class="lh-lg">{{ __('attributes.transfer.date') }}: {{ \Carbon\Carbon::parse($checkin->date)->format('d/m/Y') }}</span>
                        <span class="lh-lg">{{ __('attributes.checkin.ref') }}: {{ $checkin->reference }}</span>
                        <span class="lh-lg">{{ __('attributes.transfer.create_at') }}: {{ \Carbon\Carbon::parse($checkin->created_at)->format('d/m/Y, H:i:s') }}</span>
                    </div>
                    <div class="col-6 d-flex flex-column text-start">
                        <span class="font-bold lh-lg">{{__('attributes.checkin.contact')}}:</span>
                        <span class="lh-lg">{{ $checkin->contact->name }}</span>
                        <span class="lh-lg">{{ $checkin->contact->address ?? '' }}</span>
                        <span class="lh-lg">{{ $checkin->contact->phone ?? '' }}</span>
                        <span class="lh-lg">{{ $checkin->contact->email ?? '' }}</span>
                    </div>
                </div>
                <table class="w-full mt-8 mb-4">
                    <tr>
                        <th class="px-6 py-2 text-left">{{ __('attributes.transfer.items') }}</th>
                        <th class="px-6 py-2 w-40 text-center">
                            {{ get_settings('track_weight') ? __('attributes.item.weight') : '' }}</th>
                        <th class="px-6 py-2 w-40 text-center">{{ __('attributes.item.quantity') }}</th>
                    </tr>
                    @foreach ($checkin->items as $item)
                        @if (is_null($item->variations) || $item->variations->isEmpty())
                            <tr class="group avoid border-b">
                                <td class="group-hover:bg-gray-100 border-t px-6 py-2">{{ $item->item->name }} ({{ $item->item->code }})</td>
                                <td class="group-hover:bg-gray-100 border-t px-6 py-2 text-center">
                                    {{ (isset($setting['track_weight']) && $setting['track_weight'] != 0) ? 
                                        (($item->track_weight != 0 && $item->weight != null) ? 
                                        (formatNumber($item->weight) . ' ' . $setting['weight_unit'] ?? 'kg') : '') : '' }}
                                <td class="group-hover:bg-gray-100 border-t px-6 py-2 text-center">    {{ formatNumber($item->quantity) . ' ' . ($item->unit ? $item->unit->code : '') }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="3" class="font-bold group-hover:bg-gray-100 border-t px-6 py-2">{{ $item->item->name }} ({{ $item->item->code }})</td>
                            </tr>
                            @foreach ($item->variations as $variation)
                                @php
                                    $variantName = '';
                                    foreach ($variation->meta as $key => $value) {
                                        $variantName .= $key . ': <span class="fw-bold">' . $value . '</span> , ';
                                    }
                                    $variantName = preg_replace('/, $/', '', $variantName);
                                @endphp
                                <tr class="group avoid {{ $loop->last ? 'border-b' : '' }}">
                                    <td class="group-hover:bg-gray-100 px-6 py-2">
                                        @php
                                            echo $variantName;
                                        @endphp
                                    </td>
                                    <td class="group-hover:bg-gray-100 px-6 py-2 text-center">
                                        {{ (isset($setting['track_weight']) && $setting['track_weight'] != 0) ? 
                                            (($item->item->track_weight != 0 && $variation->pivot->weight != null) ? 
                                            (formatNumber($variation->pivot->weight) . ' ' . $setting['weight_unit'] ?? 'kg') : '') : '' }}</td>
                                    <td class="group-hover:bg-gray-100 px-6 py-2 text-center">{{ formatNumber($variation->pivot->quantity) . ' ' . ($variation->getUnitAttribute() ? $variation->getUnitAttribute()->code : '') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </table>
                <div class="mb-4 attachments">
                    <label for="formFile" class="form-label">
                    {{ __('attributes.transfer.attachment') }}
                    </label>
                   <input name="filepond" hidden>
                </div>
                
                <div class="line-clamp-3 text-start ">
                    {{$checkin->details ?? ''}}
                </div>
            </div>
        </div>
    </div>

    
    @push('js')
        <script type="module">
             $(document).ready(function () {

                JsBarcode("#barcode", "{{ $checkin->reference }}", {
                    format: 'CODE128',
                    lineColor: "#000000",
                    width: 2,
                    height: 100,
                    displayValue: true
                });

                const attachmentArray = @json($checkin->attachments);
                
                if (attachmentArray.length !== 0) {                       
                    const attachments = document.querySelector('input[name="filepond"]');                        
                    const pond = FilePond.create(attachments,{
                        allowDrop:false,
                        allowBrowse:false,
                        allowMultiple: true,
                        labelIdle: '',
                        onactivatefile: (file) => {
                        const filePath = file.getMetadata('path');
                        const fileName = file.getMetadata('title');
                        if (filePath) {
                            let urlDownload = "{{ route('download') }}";
                            urlDownload = `${urlDownload}?fp=${filePath}&fn=${fileName}`;
                            window.open(urlDownload, '_blank');
                        }
                        },
                    });
                    $.each(attachmentArray, function (key, val) {
                        fetch(val.url)
                        .then(response => response.blob())
                        .then(blob => {
                            const file = new File([blob], val.title, { type: val.filetype })
                            pond.addFile(file, {
                                metadata: {
                                    size: val.filesize,
                                    path: val.filepath,
                                    title: val.title
                                },
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching file:', error);
                        });
                    });
                    $(".filepond--list-scroller").addClass("top-66");
                    $(".filepond--list-scroller").addClass("h-100");
                    const lenghtFile = attachmentArray.length;
                    $('.filepond--root').height(56*lenghtFile);
                }else{
                    $('.attachments').hide();
                };
            });
        </script>
    @endpush
</x-app-layout>
