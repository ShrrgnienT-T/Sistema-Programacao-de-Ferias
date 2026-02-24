@props(['variant' => 'secondary'])

@php
    $variants = [
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'danger' => 'badge-danger',
        'info' => 'badge-info',
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
    ];
@endphp

<span {{ $attributes->class('badge '.$variants[$variant]) }}>{{ $slot }}</span>
