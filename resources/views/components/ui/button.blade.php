@props(['variant' => 'primary', 'type' => 'button'])

@php
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'success' => 'btn-success',
        'danger' => 'btn-danger',
        'warning' => 'btn-warning',
        'outline-primary' => 'btn-outline-primary',
    ];
@endphp

<button type="{{ $type }}" {{ $attributes->class('btn '.$variants[$variant]) }}>
    {{ $slot }}
</button>
