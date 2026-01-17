<div class="min-h-screen pb-20 bg-base-200/30">

    <div class="relative w-full h-[50vh] md:h-[60vh]">
        <img src="{{ $moment->getFirstMediaUrl('albums') }}" alt="{{ $moment->name }}"
            class="w-full h-full object-cover" />

        <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent"></div>

        <a href="{{ route('moments.index') }}"
            class="absolute top-6 left-6 btn btn-circle btn-ghost bg-black/20 text-white hover:bg-black/40 border-none backdrop-blur-sm">
            <x-mary-icon name="o-arrow-left" class="w-6 h-6" />
        </a>
    </div>

    <div class="container mx-auto px-4 -mt-20 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                <div class="card bg-base-100 shadow-xl overflow-hidden">
                    <div class="card-body p-6 md:p-10">

                        <div class="border-b pb-6 mb-6">
                            <div
                                class="flex items-center gap-2 text-warning mb-2 font-semibold tracking-wide uppercase text-sm">
                                <x-mary-icon name="o-sparkles" class="w-5 h-5" />
                                Special Moment
                            </div>
                            <h1 class="text-4xl md:text-5xl font-bold text-base-content">{{ $moment->name }}</h1>
                        </div>

                        <div class="prose prose-lg max-w-none text-base-content/80">
                            <p class="leading-relaxed">
                                {{ $moment->details ?? 'Capture the perfect ' . $moment->name . ' moment. This special occasion deserves professional photography to preserve your precious memories forever.' }}
                            </p>
                        </div>

                    </div>
                </div>

                @if ($moment->getMedia('albums')->count() > 0)
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title text-2xl font-bold mb-6">Gallery Album</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($moment->getMedia('albums') as $media)
                                    <div class="group relative aspect-square rounded-xl overflow-hidden cursor-pointer">
                                        <img src="{{ $media->getUrl() }}" alt="Album {{ $moment->name }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">

                    <div class="card bg-base-100 shadow-2xl border-t-4 border-primary">
                        <div class="card-body">
                            <h3 class="text-lg font-medium text-gray-500">Book This Moment</h3>

                            <div class="divider my-2"></div>

                            <div class="form-control w-full mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold">Select City</span>
                                </label>
                                <x-mary-select wire:model.live="selectedCity" :options="$this->cities" option-value="slug"
                                    option-label="name" placeholder="Choose a city..." class="select-bordered" />
                            </div>

                            @if ($this->selectedCityData)
                                <div class="flex items-baseline gap-1 my-2">
                                    <span class="text-xs font-bold text-gray-500 relative -top-4">IDR</span>
                                    <span class="text-4xl font-extrabold text-primary">
                                        {{ number_format($this->selectedCityData->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @else
                                <div class="text-center text-gray-400 py-4">
                                    <x-mary-icon name="o-map-pin" class="w-8 h-8 mx-auto mb-2" />
                                    <p class="text-sm">Select a city to see the price</p>
                                </div>
                            @endif

                            <div class="divider my-2"></div>

                            <ul class="space-y-3 text-sm text-gray-600 mb-6">
                                <li class="flex items-center gap-2">
                                    <x-mary-icon name="o-check-circle" class="w-5 h-5 text-success" />
                                    <span>Professional Photographer</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-mary-icon name="o-check-circle" class="w-5 h-5 text-success" />
                                    <span>30+ Edited Photos</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-mary-icon name="o-check-circle" class="w-5 h-5 text-success" />
                                    <span>1-2 Hours Session</span>
                                </li>
                            </ul>

                            <button class="btn btn-primary btn-block text-white shadow-lg group" wire:click="reserve"
                                @disabled(!$selectedCity)>
                                Book Now
                                <x-mary-icon name="o-arrow-right"
                                    class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                            </button>


                        </div>
                    </div>

                    <div class="alert shadow-lg bg-white">
                        <x-mary-icon name="o-chat-bubble-left-right" class="text-info w-6 h-6" />
                        <div>
                            <h3 class="font-bold text-sm">Need Help?</h3>
                            <div class="text-xs text-gray-500">Chat with our support team</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
