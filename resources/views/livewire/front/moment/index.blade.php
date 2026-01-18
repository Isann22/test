<div class="container mx-auto px-4 py-12">

    <div class="flex flex-col md:flex-row justify-center lg:justify-between items-center mb-10 gap-4">

        <div class="text-center md:text-left">
            <h1 class="text-4xl font-bold text-base-content">All Moments</h1>
            <p class="text-base-content/60 mt-2">Capture your special moments with us</p>
        </div>

        <div class="max-w-md mx-auto md:max-w-none md:mx-0 md:w-1/3 lg:w-1/4">
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 place-items-center">
        @forelse ($this->moments as $moment)
            <div
                class="overflow-hidden bg-white rounded shadow-md text-slate-500 shadow-slate-200 w-full max-w-sm group relative transition-all duration-300 hover:shadow-2xl">
                <a href="{{ route('moments.show', $moment->slug) }}" class="absolute inset-0 z-20"></a>

                <figure class="relative h-64">
                    <img src="{{ $moment->getFirstMediaUrl('albums') ?: 'https://placehold.co/400x300?text=' . urlencode($moment->name) }}"
                        alt="{{ $moment->name }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />

                    <figcaption
                        class="absolute bottom-0 left-0 w-full p-6 text-white bg-linear-to-t from-slate-900/90 to-transparent">
                        <div class="flex items-center gap-1 mb-1">
                            <x-mary-icon name="o-camera" class="w-4 h-4 text-warning" />
                            <h3 class="text-lg font-medium leading-tight">{{ $moment->name }}</h3>
                        </div>
                        <p class="text-sm opacity-90 text-slate-300 line-clamp-1">
                            {{ Str::limit($moment->details, 50) }}
                        </p>
                    </figcaption>
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
