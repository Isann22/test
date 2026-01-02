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
            <p class="text-gray-500 text-lg">Get inspired to create your own beautiful moments!</p>
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

            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-base-content mb-2">Featured Destinations</h2>
                    <p class="text-gray-500 text-lg">Favourite places to capture your memories in Indonesia</p>
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

            <div id="dest-carousel"
                class="carousel carousel-center w-full p-4 space-x-6 bg-transparent rounded-box overflow-x-auto scroll-smooth">

                @foreach ($destinations as $destination)
                    <div class="carousel-item">
                        <div
                            class="card bg-base-100 image-full w-72 md:w-80 h-96 shadow-xl before:opacity-10 hover:before:opacity-20 transition-all duration-300 group cursor-pointer">
                            <figure>
                                <img src="{{ $destination['image'] }}" alt="{{ $destination['city'] }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                            </figure>

                            <div class="card-body p-6 flex flex-col justify-between">

                                <div class="flex items-start gap-1 text-white/90">
                                    <x-mary-icon name="o-map-pin" class="w-5 h-5 mt-1 text-warning" />
                                    <div>
                                        <h3 class="font-bold text-2xl leading-tight">{{ $destination['city'] }}</h3>
                                        <span class="text-sm opacity-80">{{ $destination['province'] }}</span>
                                    </div>
                                </div>

                                <div class="mt-auto space-y-2">
                                    <div
                                        class="flex items-center gap-2 text-white/80 text-sm bg-black/20 backdrop-blur-sm p-2 rounded-lg w-fit">
                                        <x-mary-icon name="o-calendar" class="w-4 h-4" />
                                        <span>{{ $destination['season'] }}</span>
                                    </div>

                                    <div>
                                        <p class="text-xs text-white/70">Start from</p>
                                        <p class="text-xl font-bold text-white">{{ $destination['price'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

</div>
