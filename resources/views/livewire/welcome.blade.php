<div class="w-full flex flex-col gap-16 ">
    <section id="hero" class="container mx-auto px-6 py-12 ">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div class="text-left space-y-6">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight text-base-content">
                    Capture your moments <br>
                </h1>

                <p class="text-lg text-base-content/70">
                    Browse and book photography services easily!
                </p>

                <div class="flex gap-3">
                    <x-mary-button label="Book Now" link="{{ route('destinations.index') }}" class="btn-neutral px-8"
                        icon="o-camera" />
                </div>
            </div>

            <div class="flex justify-center md:justify-end">
                <img src="{{ asset('images/Image.png') }}" alt="Photographer Illustration" class="" />
            </div>
        </div>
    </section>

    <section id="moments" class="container mx-auto px-6 py-12">

        <div class="mb-10 text-left">
            <h2 class="text-3xl md:text-4xl font-bold text-base-content mb-2">Photography for Every Milestone</h2>
            <p class="text-base-content/70 text-lg">Get inspired to create your own beautiful moments!</p>
            <a href="{{ route('moments.index') }}"
                class="text-primary text-sm font-bold hover:bg-transparent hover:underline">
                See All Moments <x-mary-icon name="o-arrow-right" class="w-4 h-4 " />
            </a>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 place-items-center">
            @forelse ($moments as $moment)
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
    </section>

    <section id="destinations" class="w-full py-12 bg-base-100">
        <div class="container mx-auto px-6">
            <div class="w-full space-y-4">
                <div class="flex justify-between items-end px-4">
                    <div>
                        <h2 class="text-3xl font-bold text-base-content">Popular Destinations</h2>
                        <p class="text-base-content/60 text-sm mt-1">Discover the beauty of Indonesia</p>
                    </div>
                    <div class="hidden md:flex gap-2">
                        <button class="btn btn-circle btn-sm btn-ghost"
                            onclick="document.getElementById('dest-carousel').scrollBy({left: -300, behavior: 'smooth'})">
                            <x-mary-icon name="o-chevron-left" class="w-5 h-5" />
                        </button>
                        <button class="btn btn-circle btn-sm btn-ghost"
                            onclick="document.getElementById('dest-carousel').scrollBy({left: 300, behavior: 'smooth'})">
                            <x-mary-icon name="o-chevron-right" class="w-5 h-5" />
                        </button>
                    </div>

                </div>
                <a href="{{ route('destinations.index') }}"
                    class="text-primary text-sm font-bold hover:bg-transparent hover:underline">
                    See All Cities <x-mary-icon name="o-arrow-right" class="w-4 h-4 ml-1" />
                </a>

                <div id="dest-carousel"
                    class="carousel carousel-center w-full p-4 space-x-6 bg-transparent rounded-box overflow-x-auto scroll-smooth snap-x">
                    @foreach ($cities as $city)
                        <div class="carousel-item snap-center">
                            <div
                                class="overflow-hidden bg-white rounded shadow-md text-slate-500 shadow-slate-200 w-80 group relative transition-all duration-300 hover:shadow-xl">
                                <a href="{{ route('destinations.show', $city->slug) }}"
                                    class="absolute inset-0 z-20"></a>

                                <figure class="relative h-full">
                                    <img src="{{ $city->getFirstMediaUrl('albums') }}" alt="{{ $city->name }}"
                                        class="aspect-4/3 w-full object-cover transition-transform duration-700 group-hover:scale-105" />

                                    <figcaption
                                        class="absolute bottom-0 left-0 w-full p-6 text-white bg-linear-to-t from-slate-900/90 to-transparent">
                                        <div class="flex items-center gap-1 mb-1">
                                            <x-mary-icon name="o-map-pin" class="w-4 h-4 text-warning" />
                                            <h3 class="text-lg font-medium leading-tight">{{ $city->name }}</h3>
                                        </div>
                                        <p class="text-sm opacity-90 text-slate-300">
                                            Start from <span class="font-bold text-warning">IDR
                                                {{ number_format($city->price, 0, ',', '.') }}</span>
                                        </p>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
