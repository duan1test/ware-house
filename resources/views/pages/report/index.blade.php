<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.report.total') }}</li>
            </ol>
            <p class="mt-2">{{ __('common.report.total_messages') }}</p>
        </nav>
    </div>

    <section class="mb-4 mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($data as $key => $value)
                <div class="p-4 rounded-md bg-white" style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                    <div class="flex items-start justify-between">
                        <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 truncate">{{ $value }}</h2>
                    </div>
                    <p class="leading-none text-gray-600">{{ __('common.report.total_sub.' . $key) }}</p>
                </div>
            @endforeach
        </div>
    </section>
    
    <p>{{ __('common.report.link') }}</p>
    <section class="mt-4 mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a class="p-4 rounded-md bg-gray-700" href="{{ route('reports.checkin') }}"  style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                <p class="leading-none text-gray-100">{{ __('common.report.checkin') }}</p>
            </a>
            <a class="p-4 rounded-md bg-gray-700" href="{{ route('reports.checkout') }}"  style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                <p class="leading-none text-gray-100">{{ __('common.report.checkout') }}</p>
            </a>
            <a class="p-4 rounded-md bg-gray-700" href="{{ route('reports.transfer') }}"  style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                <p class="leading-none text-gray-100">{{ __('common.report.transfer') }}</p>
            </a>
            <a class="p-4 rounded-md bg-gray-700" href="{{ route('reports.adjustment') }}"  style="box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, .10);">
                <p class="leading-none text-gray-100">{{ __('common.report.adjustments') }}</p>
            </a>
        </div>
    </section>
</x-app-layout>
