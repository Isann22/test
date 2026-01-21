<div>
    {{-- Header --}}
    <div class="text-center h-52 bg-base-200 p-5">
        <h1 class="text-4xl text-center font-bold text-base-content">Reservation Details</h1>
        <p class="text-base-content/60 mt-2">{{ $reservation->reservation_code }}</p>
    </div>

    <div class="container mx-auto px-4 -mt-10 mb-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Main Details --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Reservation Info Card --}}
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="card-title">Booking Information</h2>
                            @php
                                $statusColors = [
                                    'pending' => 'badge-warning',
                                    'confirmed' => 'badge-info',
                                    'in_progress' => 'badge-accent',
                                    'completed' => 'badge-success',
                                    'cancelled' => 'badge-error',
                                ];
                            @endphp
                            <span
                                class="badge badge-lg {{ $statusColors[$reservation->status->value] ?? 'badge-ghost' }}">
                                {{ $reservation->status->label() }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div>
                                <p class="text-xs uppercase text-base-content/50 font-semibold">Moment</p>
                                <p class="font-medium">{{ $reservation->detail?->moment?->name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-base-content/50 font-semibold">City</p>
                                <p class="font-medium">{{ $reservation->detail?->city?->name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-base-content/50 font-semibold">Date</p>
                                <p class="font-medium">
                                    {{ $reservation->detail?->photoshoot_date?->format('d F Y') ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-base-content/50 font-semibold">Time</p>
                                <p class="font-medium">{{ $reservation->detail?->photoshoot_time ?? '-' }}</p>
                            </div>
                        </div>

                        <hr class="my-4 border-base-300" />

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-xs uppercase text-base-content/50 font-semibold">Package</p>
                                <p class="font-medium">{{ $reservation->detail?->package?->name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-base-content/50 font-semibold">Pax</p>
                                <p class="font-medium">{{ $reservation->detail?->pax ?? 1 }} person(s)</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-base-content/50 font-semibold">Location</p>
                                <p class="font-medium">{{ $reservation->detail?->location ?? '-' }}</p>
                            </div>
                        </div>

                        @if ($reservation->detail?->location_details)
                            <div class="mt-4">
                                <p class="text-xs uppercase text-base-content/50 font-semibold">Location Details</p>
                                <p class="font-medium">{{ $reservation->detail->location_details }}</p>
                            </div>
                        @endif

                        @if ($reservation->detail?->additional_info)
                            <div class="mt-4">
                                <p class="text-xs uppercase text-base-content/50 font-semibold">Additional Info</p>
                                <p class="font-medium">{{ $reservation->detail->additional_info }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Photographer Card (shown for confirmed, in_progress, completed) --}}
                @if (in_array($reservation->status->value, ['confirmed', 'in_progress', 'completed']))
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title mb-4">
                                <x-mary-icon name="o-camera" class="w-5 h-5" />
                                Your Photographer
                            </h2>

                            @if ($reservation->detail?->photographer)
                                <div class="flex items-center gap-4">
                                    <div class="avatar placeholder">
                                        <div
                                            class="bg-primary flex items-center justify-center text-primary-content rounded-full w-16">
                                            <span
                                                class="text-xl">{{ substr($reservation->detail->photographer->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-bold text-lg">{{ $reservation->detail->photographer->name }}</p>
                                        <p class="text-base-content/60 text-sm">Professional Photographer</p>
                                        @if ($reservation->detail->photographer->phone_number)
                                            <p class="text-base-content/60 text-sm mt-1">
                                                <x-mary-icon name="o-phone" class="w-4 h-4 inline" />
                                                {{ $reservation->detail->photographer->phone_number }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-4">
                                    <div class="avatar placeholder">
                                        <div
                                            class="bg-base-300 flex items-center justify-center text-base-content/50 rounded-full w-16">
                                            <x-mary-icon name="o-user" class="w-8 h-8" />
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-base-content/70">Assigning photographer...</p>
                                        <p class="text-base-content/50 text-sm">We'll notify you once a photographer is
                                            assigned</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Drive Link Card (shown only for completed) --}}
                @if ($reservation->status->value === 'completed' && $driveLink)
                    <div class="card bg-linear-to-r from-success/10 to-success/5 border border-success/20 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title text-success mb-2">
                                <x-mary-icon name="o-photo" class="w-5 h-5" />
                                Your Photos are Ready!
                            </h2>
                            <p class="text-base-content/70 mb-4">
                                Your photoshoot results have been uploaded. Click the button below to view and download
                                your photos.
                            </p>
                            <a href="{{ $driveLink }}" target="_blank" class="btn btn-success w-full md:w-auto">
                                <x-mary-icon name="o-arrow-top-right-on-square" class="w-4 h-4" />
                                Open Google Drive
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right: Payment Summary --}}
            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-xl sticky top-4">
                    <div class="card-body">
                        <h2 class="card-title border-b pb-3">Payment Summary</h2>

                        <div class="space-y-4 py-4">
                            <div class="flex justify-between">
                                <span class="text-base-content/70">Package Price</span>
                                <span class="font-semibold">Rp
                                    {{ number_format($reservation->package_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-base-content/70">Tax ({{ $reservation->tax_rate * 100 }}%)</span>
                                <span class="font-semibold">Rp
                                    {{ number_format($reservation->tax_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold">Total</span>
                                <span class="text-xl font-bold text-primary">Rp
                                    {{ number_format($reservation->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if ($reservation->payment)
                            <div class="mt-4 pt-4 border-t">
                                <div class="flex justify-between items-center">
                                    <span class="text-base-content/70">Payment Status</span>
                                    @php
                                        $paymentColors = [
                                            'pending' => 'badge-warning',
                                            'paid' => 'badge-success',
                                            'failed' => 'badge-error',
                                            'expired' => 'badge-ghost',
                                        ];
                                    @endphp
                                    <span
                                        class="badge {{ $paymentColors[$reservation->payment->payment_status->value] ?? 'badge-ghost' }}">
                                        {{ $reservation->payment->payment_status->label() }}
                                    </span>
                                </div>
                                @if ($reservation->payment->paid_at)
                                    <p class="text-xs text-base-content/50 mt-2">
                                        Paid on {{ $reservation->payment->paid_at->format('d M Y, H:i') }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('reserved.index') }}" class="btn btn-ghost w-full">
                                <x-mary-icon name="o-arrow-left" class="w-4 h-4" />
                                Back to Reservations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
