<div>
    {{-- Header --}}
    <div class="text-center h-52 bg-base-200 p-5">
        <h1 class="text-4xl text-center font-bold text-base-content">My Reservations</h1>
        <p class="text-base-content/60 mt-2">View and manage your photoshoot bookings</p>
    </div>

    <div class="container mx-auto px-4 -mt-10 mb-10">
        {{-- Filters --}}
        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body py-4">
                <div class="flex flex-wrap items-center gap-4">
                    <span class="text-sm font-semibold text-base-content/70">Filter by Status:</span>
                    <div class="flex flex-wrap gap-2">
                        <button wire:click="$set('statusFilter', '')"
                            class="btn btn-sm {{ $statusFilter === '' ? 'btn-primary' : 'btn-ghost' }}">
                            All
                        </button>
                        <button wire:click="$set('statusFilter', 'pending')"
                            class="btn btn-sm {{ $statusFilter === 'pending' ? 'btn-warning' : 'btn-ghost' }}">
                            Pending
                        </button>
                        <button wire:click="$set('statusFilter', 'confirmed')"
                            class="btn btn-sm {{ $statusFilter === 'confirmed' ? 'btn-info' : 'btn-ghost' }}">
                            Confirmed
                        </button>
                        <button wire:click="$set('statusFilter', 'completed')"
                            class="btn btn-sm {{ $statusFilter === 'completed' ? 'btn-success' : 'btn-ghost' }}">
                            Completed
                        </button>
                        <button wire:click="$set('statusFilter', 'cancelled')"
                            class="btn btn-sm {{ $statusFilter === 'cancelled' ? 'btn-error' : 'btn-ghost' }}">
                            Cancelled
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reservation List --}}
        @if ($this->reservations->isEmpty())
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body items-center text-center py-16">
                    <x-mary-icon name="o-calendar-days" class="w-16 h-16 text-base-content/30" />
                    <h3 class="text-xl font-semibold text-base-content/70 mt-4">No reservations yet</h3>
                    <p class="text-base-content/50">Start by booking your first photoshoot!</p>
                    <a href="{{ route('destinations.index') }}" class="btn btn-primary mt-4">
                        <x-mary-icon name="o-camera" class="w-5 h-5" />
                        Browse Cities
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($this->reservations as $reservation)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                        <div class="card-body">
                            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                                {{-- Left: Reservation Info --}}
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-bold text-base-content">
                                            {{ $reservation->reservation_code }}
                                        </h3>
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
                                            class="badge {{ $statusColors[$reservation->status->value] ?? 'badge-ghost' }}">
                                            {{ $reservation->status->label() }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-base-content/50 text-xs uppercase">Moment</p>
                                            <p class="font-medium">{{ $reservation->detail?->moment?->name ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-base-content/50 text-xs uppercase">City</p>
                                            <p class="font-medium">{{ $reservation->detail?->city?->name ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-base-content/50 text-xs uppercase">Date</p>
                                            <p class="font-medium">
                                                {{ $reservation->detail?->photoshoot_date?->format('d M Y') ?? '-' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-base-content/50 text-xs uppercase">Time</p>
                                            <p class="font-medium">{{ $reservation->detail?->photoshoot_time ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right: Price & Actions --}}
                                <div class="flex flex-col items-end gap-2 min-w-[180px]">
                                    <div class="text-right">
                                        <p class="text-base-content/50 text-xs uppercase">Total</p>
                                        <p class="text-xl font-bold text-primary">
                                            Rp {{ number_format($reservation->total_amount, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    @if ($reservation->status->value === 'pending')
                                        <div class="flex gap-2">
                                            <button class="btn btn-sm btn-primary"
                                                wire:click="submit('{{ $reservation->id }}', '{{ $reservation->payment->gateway_response['snap_token'] }}')">
                                                <x-mary-icon name="o-credit-card" class="w-4 h-4" />
                                                Pay Now
                                            </button>
                                            <button class="btn btn-sm btn-ghost text-error">
                                                Cancel
                                            </button>
                                        </div>
                                    @elseif (in_array($reservation->status->value, ['confirmed', 'in_progress', 'completed']))
                                        <a href="{{ route('reserved.show', $reservation) }}"
                                            class="btn btn-sm btn-outline btn-primary">
                                            <x-mary-icon name="o-eye" class="w-4 h-4" />
                                            View Details
                                        </a>
                                    @endif

                                    <p class="text-xs text-base-content/40">
                                        Booked {{ $reservation->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $this->reservations->links() }}
            </div>
        @endif
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            let currentReservationId = null;

            Livewire.on('open-snap-popup', function(event) {
                const snapToken = event.token;
                currentReservationId = event.reservationId;

                snap.pay(snapToken, {
                    onSuccess: function(result) {

                        Livewire.dispatch('payment-success', {
                            reservationId: currentReservationId,
                            result: result
                        });
                    },
                    onPending: function(result) {

                        Livewire.dispatch('payment-pending', {
                            result: result
                        });
                    },
                    onError: function(result) {

                        Livewire.dispatch('payment-error', {
                            reservationId: currentReservationId,
                            result: result
                        });
                    },
                    onClose: function() {
                        Livewire.dispatch('payment-closed');
                    }
                });
            });
        });
    </script>
@endpush
