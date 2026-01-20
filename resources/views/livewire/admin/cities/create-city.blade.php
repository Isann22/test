<div class="max-w-4xl mx-auto">
    <x-filament::section>
        <x-slot name="heading">
            Create New City
        </x-slot>

        <x-slot name="description">
            Add a new city destination with its details and images.
        </x-slot>

        <form wire:submit="create">
            {{ $this->form }}

            <div class="mt-6 flex items-center gap-4">
                <x-filament::button type="submit">
                    Create City
                </x-filament::button>

                <x-filament::button color="gray" tag="a" href="/admin/cities">
                    Cancel
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</div>
