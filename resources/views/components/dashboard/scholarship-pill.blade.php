@php
    $colors = [
        'gradient-green',
        'gradient-red',
        'gradient-purple',
        'gradient-pink',
        'gradient-yellow',
        'gradient-orange',
        'gradient-teal',
    ];
@endphp
<a href="{{ route('scholarship.show', $scholarship) }}"
    class=" group p-4 px-5 mb-2 relative flex justify-center items-center text-sm font-medium text-blue-100 text-center rounded-lg bg-gradient-to-r {{ $colors[$index % count($colors)] }}">
    <h4>{{ $scholarship->name }}</h4>
    <x-icons.edit class="w-4 h-4 absolute right-4 hidden group-hover:block hover:cursor-pointer"/>
</a>
