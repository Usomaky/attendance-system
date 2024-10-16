@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'p-0 text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
