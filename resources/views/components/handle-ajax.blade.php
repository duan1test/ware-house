@props([
    'url' => '',
    'method' => 'get',
])
<div class="handle-ajax" data-url="{{ $url }}" data-method="{{ $method }}">
    {{ $slot }}
</div>

@push('js')
    @vite('resources/js/import.js')
@endpush