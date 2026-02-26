@props([
    'for' => null,
    'required' => false,
])

<label @if($for) for="{{ $for }}" @endif {{ $attributes }}>
    {{ $slot }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>
