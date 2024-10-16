@props(['active'])

@php
$classes = ($active ?? false)
            ? 'w-full inline-flex items-center text-md font-medium leading-5 text-blue-700 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out py-2 px-3 hover:bg-gray-100 bg-gray-100 no-underline'
            : 'w-full inline-flex items-center text-md font-medium leading-5 text-blue-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out py-2 px-3 hover:bg-gray-100 no-underline';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
