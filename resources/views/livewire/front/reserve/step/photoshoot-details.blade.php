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
                            <x-mary-datetime label="Date" wire:model="bookingDate" icon="o-calendar"
                                hint="Select your preferred date" class="w-full" />
                        </div>

                        <div>
                            <x-mary-select label="Time" icon="o-clock" :options="$timeSlots ?? [
                                ['id' => '09:00', 'name' => '09:00 AM'],
                                ['id' => '10:00', 'name' => '10:00 AM'],
                            ]"
                                placeholder="What time do you want to shoot?" />
                        </div>

                        <div>
                            <x-mary-input label="Pax" type="number" wire:model="pax" placeholder="Number of people"
                                min="1" />
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
                    <h3 class="font-bold text-lg mb-4 text-base-content">Booking Details</h3>

                    <div class="card bg-base-100 border border-base-200 shadow-sm">
                        <div class="card-body p-6">
                            <h2 class="text-xl font-bold text-primary">Pre-wedding</h2>

                            <div class="mt-4 space-y-3">
                                <div class="flex items-center gap-3 text-base-content/70">
                                    <x-mary-icon name="o-map-pin" class="w-5 h-5" />
                                    <span>lorem</span>
                                </div>
                                <div class="flex items-center gap-3 text-base-content/70">
                                    <x-mary-icon name="o-clock" class="w-5 h-5" />
                                    <span>lorem</span>
                                </div>
                            </div>

                            <div class="divider my-2"></div>

                            <div class="flex justify-between items-end">
                                <span class="text-sm text-base-content/60">Subtotal</span>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-warning">USD 269</div>
                                    <div class="text-xs text-base-content/50">Approx. IDR 4.510.000</div>
                                </div>
                            </div>

                            <x-mary-button label="Checkout" class="btn-primary w-full mt-6 text-white font-bold"
                                wire:click="checkout" />
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
