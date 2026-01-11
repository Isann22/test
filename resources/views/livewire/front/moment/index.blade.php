<div class="container mx-auto px-4 py-12">

    {{-- Header & Search --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-bold text-base-content">All Moments</h1>
            <p class="text-base-content/60 mt-2">Capture your special moments with us</p>
        </div>

        <div class="w-full md:w-1/3">
            <label class="input input-bordered flex items-center gap-2 rounded-full shadow-sm">
                <input type="text" wire:model.live.debounce.300ms="search" class="grow"
                    placeholder="Search moment..." />
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                    class="w-4 h-4 opacity-70">
                    <path fill-rule="evenodd"
                        d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                        clip-rule="evenodd" />
                </svg>
            </label>
        </div>
    </div>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 place-items-center">
        @forelse ($this->moments as $moment)
            <div
                class="card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group w-full max-w-sm">
                <figure class="relative h-56 overflow-hidden">
                    <img src="{{ $moment->getFirstMediaUrl('albums') ?: 'https://placehold.co/400x300?text=' . urlencode($moment->name) }}"
                        alt="{{ $moment->name }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />

                    {{-- Overlay dengan gradient --}}
                    <div
                        class="absolute inset-0 bg-linear-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-5">
                        <h3 class="text-xl font-bold text-white mb-1">{{ $moment->name }}</h3>
                        <p class="text-sm text-white/80 mb-3 line-clamp-2">{{ Str::limit($moment->details, 60) }}</p>
                        <x-mary-button label="Explore" icon="o-arrow-right" class="btn btn-neutral btn-sm w-fit"
                            link="#" />
                    </div>
                </figure>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 mb-2">
                    <x-mary-icon name="o-face-frown" class="w-12 h-12 mx-auto" />
                </div>
                <h3 class="text-lg font-bold text-gray-600">No moments found</h3>
            </div>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center">
        {{ $this->moments->links() }}
    </div>
</div>
