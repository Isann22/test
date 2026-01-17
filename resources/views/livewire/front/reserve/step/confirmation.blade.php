<div>
    <div class="text-center h-52 bg-base-200 p-5">
        <h1 class="text-4xl text-center font-bold text-base-content">Confirm Your Booking</h1>
        <p class="text-base-content/60 mt-2">Review your booking details before payment</p>
    </div>

    <div class="card w-full container mx-auto bg-base-100 -mt-10 card-lg shadow-xl mb-10">

        <div class="card-body">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                {{-- Left Side: Booking Summary --}}
                <div class="lg:col-span-2">
                    <div class="card card-border bg-base-100 shadow-sm">
                        <div class="card-body space-y-6">
                            {{-- Moment Name --}}
                            <h2 class="text-2xl font-bold text-base-content">{{ $booking['momentName'] }}</h2>

                            {{-- Photo Details Grid --}}
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs uppercase text-base-content/60 font-semibold">Photo Location</p>
                                    <p class="text-base-content font-medium">{{ $booking['cityName'] }}, Indonesia</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-base-content/60 font-semibold">Photo Date</p>
                                    <p class="text-base-content font-medium">
                                        {{ $booking['date'] ? \Carbon\Carbon::parse($booking['date'])->format('d F Y') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-base-content/60 font-semibold">Photo Time</p>
                                    <p class="text-base-content font-medium">{{ $booking['time'] ?? '-' }}</p>
                                </div>
                            </div>

                            <hr class="border-base-300" />

                            {{-- Package Details --}}
                            <div class="space-y-3">
                                <h3 class="text-sm uppercase text-base-content/60 font-semibold">Package</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-center gap-3">
                                        <x-mary-icon name="o-clock" class="w-5 h-5 text-base-content/60" />
                                        <span>{{ $booking['hourDuration'] }}
                                            Hour{{ $booking['hourDuration'] > 1 ? 's' : '' }} Duration</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <x-mary-icon name="o-photo" class="w-5 h-5 text-base-content/60" />
                                        <span>{{ $booking['editedPhotos'] }}+ Edited Photos</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <x-mary-icon name="o-arrow-down-tray" class="w-5 h-5 text-base-content/60" />
                                        <span>{{ $booking['downloadablePhotos'] }} Downloadable Photos</span>
                                    </li>
                                </ul>
                            </div>

                            <hr class="border-base-300" />

                            {{-- Policy --}}
                            <div class="space-y-3">
                                <h3 class="text-sm uppercase text-base-content/60 font-semibold">Policy</h3>
                                <div class="text-sm text-base-content/70 space-y-2">
                                    <p>• Free cancellation up to 48 hours before the photoshoot</p>
                                    <p>• Photos will be delivered within 5-7 business days</p>
                                    <p>• Weather-related reschedules are free of charge</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Payment Details --}}
                <div class="lg:col-span-1">
                    <div class="card bg-base-100 border border-base-200 shadow-lg sticky top-4">
                        <div class="card-body">
                            <h3 class="text-lg font-bold text-base-content border-b pb-3">Payment Details</h3>

                            <div class="space-y-4 py-4">
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Subtotal</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($booking['subtotal'], 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Include {{ $booking['taxRate'] * 100 }}%
                                        Tax</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($booking['tax'], 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold">Total Payment</span>
                                    <span class="text-xl font-bold text-primary">Rp
                                        {{ number_format($booking['total'], 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <p class="text-xs text-base-content/60 mt-4">
                                By clicking this button, you've agreed to the
                                <a href="#" class="text-primary hover:underline">Terms & Conditions</a>
                            </p>

                            <x-mary-button label="Continue to Payment" class="btn-primary w-full mt-4"
                                icon-right="o-arrow-right" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
