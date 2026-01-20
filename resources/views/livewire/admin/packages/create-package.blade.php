<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.packages.index') }}"
            class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-1" />
            Back to Packages
        </a>
        <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">Create Package</h1>
    </div>

    <x-filament::section>
        <form wire:submit="create" class="space-y-6">
            {{ $this->form }}

            <div class="flex justify-end gap-3">
                <x-filament::button type="button" color="gray" href="{{ route('admin.packages.index') }}"
                    tag="a">
                    Cancel
                </x-filament::button>
                <x-filament::button type="submit">
                    Create Package
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</div>
