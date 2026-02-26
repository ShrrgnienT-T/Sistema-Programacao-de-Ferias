@props([
    'route',
    'title' => 'Tem certeza?',
    'text' => 'Esta ação não poderá ser desfeita!',
    'icon' => 'trash',
    'size' => 'sm',
    'variant' => 'danger',
])

@php
   $sizeClasses = [
       'xs' => 'px-2 py-1 text-xs',
       'sm' => 'px-3 py-1.5 text-sm',
       'md' => 'px-4 py-2 text-base',
       'lg' => 'px-5 py-2.5 text-lg',
   ];

   $variantClasses = [
       'danger' => 'bg-red-600 hover:bg-red-700 text-white border-red-600',
       'outline-danger' => 'bg-transparent hover:bg-red-600 text-red-600 hover:text-white border border-red-600',
       'ghost' => 'bg-transparent hover:bg-red-100 text-red-600 border-transparent',
   ];

   $baseClasses =
       'inline-flex items-center justify-center font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
   $classes =
       $baseClasses .
       ' ' .
       ($sizeClasses[$size] ?? $sizeClasses['sm']) .
       ' ' .
       ($variantClasses[$variant] ?? $variantClasses['danger']);
@endphp

<button type="button" data-confirm-delete data-route="{{ $route }}" data-title="{{ $title }}"
   data-text="{{ $text }}" {{ $attributes->merge(['class' => $classes]) }}>
   @if ($icon === 'trash')
      <svg class="w-4 h-4 {{ $slot->isEmpty() ? '' : 'mr-1.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
      </svg>
   @endif
   {{ $slot }}
</button>
