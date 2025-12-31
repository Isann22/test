@props(['label', 'name', 'placeholder' => '', 'required' => false, 'type' => 'text'])
<div class="flex flex-col gap-1 flex-1">

    <label for="{{ $name }}" class="floating-label text-black">
        <span>{{ $label }}</span>
        <input
            {{ $attributes->merge([
                'type' => $type,
                'id' => $name,
                'name' => $name,
                'placeholder' => $placeholder,
                'required' => $required,
                'class' => 'input  w-full rounded-lg',
            ]) }}
            wire:model.blur="{{ $name }}" />
    </label>

    @error($name)
        <p class="label text-sm text-red-500"> {{ $message }}</p>
    @enderror

</div>
