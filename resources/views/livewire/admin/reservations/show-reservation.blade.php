<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.reservations.index') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mb-2">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-1" />
                Back to Reservations
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $reservation->reservation_code }}
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Created {{ $reservation->created_at->format('d M Y H:i') }}
            </p>
        </div>

        {{-- Status Select --}}
        <div class="w-full sm:w-48">
            {{ $this->form }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Customer & Booking Info --}}
        <x-filament::section>
            <x-slot name="heading">Customer & Booking</x-slot>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Customer</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">{{ $reservation->user->name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $reservation->user->email }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">City</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $reservation->detail->city->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Moment</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $reservation->detail->moment->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Package</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $reservation->detail->package->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Date</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">
                        {{ $reservation->detail->photoshoot_date?->format('d M Y') ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Time</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $reservation->detail->photoshoot_time ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Pax</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $reservation->detail->pax ?? '-' }}</dd>
                </div>
            </dl>
        </x-filament::section>

        {{-- Payment Info --}}
        <x-filament::section>
            <x-slot name="heading">Payment</x-slot>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Package Price</dt>
                    <dd class="text-gray-900 dark:text-white">Rp
                        {{ number_format($reservation->package_price, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Tax
                        ({{ number_format($reservation->tax_rate * 100, 2) }}%)</dt>
                    <dd class="text-gray-900 dark:text-white">Rp
                        {{ number_format($reservation->tax_amount, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                    <dt class="font-bold text-gray-900 dark:text-white">Total</dt>
                    <dd class="font-bold text-primary-600 dark:text-primary-400">Rp
                        {{ number_format($reservation->total_amount, 0, ',', '.') }}</dd>
                </div>
                @if ($reservation->payment)
                    <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                        <dt class="text-gray-500 dark:text-gray-400">Payment Status</dt>
                        <dd>
                            <x-filament::badge :color="match ($reservation->payment->payment_status) {
                                'success', 'settlement' => 'success',
                                'pending' => 'warning',
                                'paid' => 'primary',
                                default => 'danger',
                            }">
                                {{ $reservation->payment->payment_status->label() }}
                            </x-filament::badge>
                        </dd>
                    </div>
                @endif
            </dl>
        </x-filament::section>
    </div>

    {{-- Photographer Section --}}
    <x-filament::section>
        <x-slot name="heading">Photographer</x-slot>

        @if ($reservation->detail?->photographer)
            {{-- Show assigned photographer --}}
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Assigned Photographer</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">
                        {{ $reservation->detail->photographer->name }}
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="text-gray-900 dark:text-white">
                        {{ $reservation->detail->photographer->email }}
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Phone</dt>
                    <dd class="text-gray-900 dark:text-white">
                        {{ $reservation->detail->photographer->phone_number ?? '-' }}
                    </dd>
                </div>
            </dl>
        @elseif ($reservation->status->value === 'confirmed')
            {{-- Show assignment form --}}
            <div class="space-y-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Assign a photographer to this reservation. Status will automatically change to "In Progress".
                </p>
                {{ $this->photographerForm }}
            </div>
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400">
                @if ($reservation->status->value === 'pending')
                    Waiting for payment confirmation before assigning photographer.
                @else
                    No photographer assigned.
                @endif
            </p>
        @endif
    </x-filament::section>

    @if ($reservation->detail->location_details || $reservation->detail->additional_info)
        <x-filament::section>
            <x-slot name="heading">Additional Info</x-slot>

            <dl class="space-y-3 text-sm">
                @if ($reservation->detail->location_details)
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400 mb-1">Location Details</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $reservation->detail->location_details }}</dd>
                    </div>
                @endif
                @if ($reservation->detail->additional_info)
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400 mb-1">Notes</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $reservation->detail->additional_info }}</dd>
                    </div>
                @endif
            </dl>
        </x-filament::section>
    @endif
</div>
