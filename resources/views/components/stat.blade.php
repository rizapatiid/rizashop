@props(['title','value','color'])

<div class="bg-white border rounded-xl p-5">
    <p class="text-sm text-gray-500">
        {{ $title }}
    </p>

    {{-- NILAI UTAMA --}}
    <p class="text-2xl font-bold text-{{ $color }}-600 mt-2">
        {{ $value }}
    </p>

    {{-- GARIS AKSEN --}}
    <div class="mt-3 h-1 bg-gray-100 rounded">
        <div class="h-1 bg-{{ $color }}-500 rounded w-2/3"></div>
    </div>
</div>