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
                    <x-mary-button label="Book Now" class="btn-neutral px-8" icon="o-camera" />
                </div>
            </div>

            <div class="flex justify-center md:justify-end">
                <img src="{{ asset('images/Image.png') }}" alt="Photographer Illustration" class="" />
            </div>
        </div>
    </section>

    <section id="categories" class="container mx-auto px-6 py-12">

        <div class="mb-10 text-left">
            <h2 class="text-3xl md:text-4xl font-bold text-base-content mb-2">Photography for Every Milestone</h2>
            <p class="text-base-content/70 text-lg">Get inspired to create your own beautiful moments!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($categories as $category)
                <a href="#"
                    class="card bg-base-200 hover:bg-base-300 transition-colors duration-300 h-64 relative overflow-hidden group">
                    <div class="card-body p-6 relative z-10">

                        <div class="flex justify-between items-start w-full">
                            <h3 class="card-title text-xl font-bold text-base-content">{{ $category['title'] }}</h3>
                            <x-mary-icon name="o-chevron-right"
                                class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" />
                        </div>

                        <div class="mt-2 w-2/3">
                            @if (isset($category['links']))
                                <ul class="space-y-1 mt-2">
                                    @foreach ($category['links'] as $link)
                                        <li
                                            class="flex items-center gap-1 text-gray-600 hover:text-primary font-medium">
                                            {{ $link }} <x-mary-icon name="o-chevron-right" class="w-3 h-3" />
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500 leading-relaxed">
                                    {{ $category['description'] }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div
                        class="absolute -bottom-4 -right-4 w-36 h-36 md:w-40 md:h-40 transition-transform duration-500 group-hover:scale-105">
                        <img src="{{ $category['image'] }}" alt="{{ $category['title'] }}"
                            class="w-full h-full object-cover object-center mask mask-squircle opacity-90" />
                    </div>
                </a>
            @endforeach

            <a href="#"
                class="card bg-base-200 hover:bg-primary hover:text-white transition-colors duration-300 h-64 flex flex-col items-center justify-center text-center group">
                <div class="card-body items-center justify-center">
                    <h3 class="text-2xl font-bold">Browse All <br> Categories</h3>
                    <x-mary-icon name="o-arrow-right"
                        class="w-8 h-8 mt-4 group-hover:translate-x-2 transition-transform" />
                </div>
            </a>

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
                <a href="#"
                    class="btn btn-ghost btn-sm text-primary font-bold hover:bg-transparent hover:underline">
                    See All Cities <x-mary-icon name="o-arrow-right" class="w-4 h-4 ml-1" />
                </a>

                <div id="dest-carousel"
                    class="carousel carousel-center w-full p-4 space-x-6 bg-transparent rounded-box overflow-x-auto scroll-smooth snap-x">
                    @foreach ($cities as $city)
                        <div class="carousel-item snap-center">
                            <div
                                class="overflow-hidden bg-white rounded shadow-md text-slate-500 shadow-slate-200 w-80 group relative transition-all duration-300 hover:shadow-xl">
                                <a href="" class="absolute inset-0 z-20"></a>

                                <figure class="relative h-full">
                                    <img src="{{ $city->getFirstMediaUrl('albums') }}" alt="{{ $city->name }}"
                                        class="aspect-4/3 w-full object-cover transition-transform duration-700 group-hover:scale-105" />

                                    <figcaption
                                        class="absolute bottom-0 left-0 w-full p-6 text-white bg-gradient-to-t from-slate-900/90 to-transparent">
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
</div>
</section>

</div>
