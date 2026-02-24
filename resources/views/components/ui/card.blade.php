@props(['title' => null])

<div {{ $attributes->class('card shadow-sm border-0') }}>
    @if ($title)
        <div class="card-header">
            <h3 class="card-title font-semibold">{{ $title }}</h3>
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>
</div>
