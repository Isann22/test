<div>
    <div class="text-center h-52 bg-base-200 p-5">
        <h1 class="text-4xl text-center font-bold text-base-content">Let's plan your photoshoot</h1>
        <p class="text-base-content/60 mt-2">Capture your special moments with us in {{ $cityName }}</p>
    </div>

    <div class="card w-full container mx-auto bg-base-100 -mt-6 card-lg">
        <div class="mt-8 flex justify-center">
            @include('livewire.front.reserve.navigation')
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 py-12 justify-center">
            @forelse($this->packages as $package)
                <div wire:key="package-{{ $package->id }}" class="rounded-xl hover:shadow-lg">
                    <x-mary-card title="{{ $package->name }}" shadow separator class="bg-base shadow-xl h-full">
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2">
                                <x-mary-icon name="o-clock" class="w-5 h-5 text-primary" />
                                {{ $package->hour_duration }} Hour Duration
                            </li>
                            <li class="flex items-center gap-2">
                                <x-mary-icon name="o-photo" class="w-5 h-5 text-primary" />
                                {{ $package->edited_photos }}+ Edited Photos
                            </li>
                            <li class="flex items-center gap-2">
                                <x-mary-icon name="o-arrow-down-tray" class="w-5 h-5 text-primary" />
                                {{ $package->downloadable_photos }} Downloadable Photos
                            </li>
                        </ul>

                        <x-slot:actions separator class="flex! flex-col! gap-3!">
                            <span class="text-2xl font-extrabold text-primary">
                                Rp {{ number_format($package->pivot->price, 0, ',', '.') }}
                            </span>



                            <x-mary-button label="Select" wire:click="selectAndContinue('{{ $package->id }}')"
                                spinner="selectAndContinue('{{ $package->id }}')" class=" btn-primary" />
                        </x-slot:actions>
                    </x-mary-card>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <x-mary-icon name="o-exclamation-triangle" class="w-16 h-16 text-warning mx-auto mb-4" />
                    <p class="text-lg text-base-content/60">No packages available for this city.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
