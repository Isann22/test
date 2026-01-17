<div class="">
    <div class="text-center h-52 bg-base-200 p-5">
        <h1 class="text-4xl text-center font-bold text-base-content">Lets plan your photoplan</h1>
        <p class="text-base-content/60 mt-2">Capture your special moments with us</p>
    </div>

    <div class="card w-full container mx-auto bg-base-100 -mt-10 card-lg shadow-xl mb-10">

        <div class="mt-8 flex justify-center">
            @include('livewire.front.reserve.navigation')
        </div>

        <div class="card-body">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <div class="lg:col-span-2 space-y-8">
                    <div class="card card-border p-4">
                        <h2 class="text-xl font-bold text-base-content border-b pb-2">Fill Your Photo Details</h2>

                        <div>
                            <x-mary-datetime label="Date" icon="o-calendar" hint="Select your preferred date"
                                class="w-full" />
                        </div>

                        <div>
                            <x-mary-select label="Time" icon="o-clock" :options="$timeSlots ?? [
                                ['id' => '09:00', 'name' => '09:00 AM'],
                                ['id' => '10:00', 'name' => '10:00 AM'],
                            ]"
                                placeholder="What time do you want to shoot?" />
                        </div>

                        <div>
                            <x-mary-input label="Pax" type="number" placeholder="Number of people" min="1" />
                        </div>
                    </div>

                    <div class="card card-border p-4">
                        <h2 class="text-xl font-bold text-base-content border-b pb-2">More Details of Your Photo Shoot
                        </h2>

                        <div>
                            <x-mary-select label="Location" icon="o-map-pin" :options="$location ?? [['id' => 'hotel', 'name' => 'hotel']]"
                                placeholder="Where should we meet" />
                        </div>

                        <div class="mt-2">
                            <x-mary-input placeholder="Location details" />
                        </div>

                        <div>
                            <x-mary-textarea label="Addtional info" placeholder="Here ..." rows="5" />
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <x-mary-card class="bg-base-100 border border-base-200 p-0! shadow-sm" separator>
                        <x-slot:title>
                            <div class="px-4 py-2">
                                <span class="text-lg font-bold text-base-content">Booking Details</span>
                            </div>
                        </x-slot:title>

                        <div class="px-4 space-y-4">
                            <h2 class="text-xl font-bold text-base-content">{{ $package['momentName'] }}</h2>

                            <div class="space-y-2">
                                <div class="flex items-center gap-3 text-base-content/70">
                                    <x-mary-icon name="o-map-pin" class="w-5 h-5" />
                                    <span class="text-base-content">{{ $package['cityName'] }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-base-content/70">
                                    <x-mary-icon name="o-clock" class="w-5 h-5" />
                                    <span class="text-base-content">lorem</span>
                                </div>
                            </div>

                            <div class="divider my-2"></div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-base-content/60">Subtotal</span>
                                <div class="text-xl font-bold text-neutral">
                                    Rp {{ number_format($package['price'], 0, ',', '.') }}
                                </div>
                            </div>

                            <x-mary-button label="Checkout" class="mb-4 btn-primary w-full text-white font-bold" />
                        </div>
                    </x-mary-card>

                </div>
            </div>
        </div>
    </div>
</div>
