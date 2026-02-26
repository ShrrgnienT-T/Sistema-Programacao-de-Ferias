@props(['variant' => 'secondary'])

@php
    $variants = [
        'success' => 'aprov',
        'warning' => 'pend',
        'danger' => 'danger',
        'info' => 'anali',
        'primary' => 'anali',
        'secondary' => 'pend',
    ];
@endphp

<span {{ $attributes->class('badge '.$variants[$variant]) }}>{{ $slot }}</span>
