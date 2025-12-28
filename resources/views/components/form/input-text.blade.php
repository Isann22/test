@props(['label', 'name', 'placeholder' => '', 'required' => false, 'type' => 'text'])
<div class="flex flex-col gap-1 flex-1">
    <label for="{{ $name }}" class="text-sm text-black font-semibold">{{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <input type="{{ $type }}" id="{{ $name }}" wire:model="{{ $name }}" name="{{ $name }}"
        class="w-full rounded-lg text-sm bg-white border border-gray-800 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        placeholder="{{ $placeholder }}" @if ($required) required @endif />
</div>
