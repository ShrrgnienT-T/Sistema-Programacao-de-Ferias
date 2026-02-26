@props(['variant' => 'primary', 'type' => 'button'])

@php
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-light',
        'success' => 'btn-primary',
        'danger' => 'btn-danger',
        'warning' => 'btn-light',
        'outline-primary' => 'btn-light',
    ];
@endphp

<button type="{{ $type }}" {{ $attributes->class('btn '.$variants[$variant]) }}>
    {{ $slot }}
</button>
