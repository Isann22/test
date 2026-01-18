<div>
    <div class="text-center h-52 bg-base-200 p-5">
        <h1 class="text-4xl text-center font-bold text-base-content">Let's plan your photoshoot</h1>
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

                        <div class="space-y-4 mt-4">
                            <x-mary-datetime label="Date" wire:model="date" icon="o-calendar"
                                hint="Select your preferred date" class="w-full" />

                            <x-mary-select label="Time" wire:model="time" icon="o-clock" :options="$timeSlots"
                                placeholder="What time do you want to shoot?" />

                            <x-mary-input label="Pax" wire:model="pax" type="number" placeholder="Number of people"
                                min="1" max="20" />
                        </div>
                    </div>

                    <div class="card card-border p-4">
                        <h2 class="text-xl font-bold text-base-content border-b pb-2">More Details of Your Photo Shoot
                        </h2>

                        <div class="space-y-4 mt-4">
                            <x-mary-select label="Location" wire:model="location" icon="o-map-pin" :options="$locations"
                                placeholder="Where should we meet" />

                            <x-mary-input wire:model="locationDetails"
                                placeholder="Location details (e.g. hotel name, address)" />

                            <x-mary-textarea label="Additional Info" wire:model="additionalInfo"
                                placeholder="Any special requests or notes..." rows="4" />
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-4">
                        <x-mary-card class="bg-base-100 border border-base-200 p-0! shadow-lg" separator>
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
                                        <span class="text-base-content">
                                            {{ $package['hourDuration'] }}
                                            Hour{{ $package['hourDuration'] > 1 ? 's' : '' }} Photoshoot
                                        </span>
                                    </div>
                                </div>

                                <div class="divider my-2"></div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-base-content/60">Subtotal</span>
                                    <div class="text-xl font-bold text-primary">
                                        Rp {{ number_format($package['price'], 0, ',', '.') }}
                                    </div>
                                </div>
                                <x-mary-button label="Checkout" wire:click="submit" spinner="submit"
                                    class="mb-4 btn-primary w-full text-white font-bold" icon-right="o-arrow-right" />
                            </div>
                        </x-mary-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
