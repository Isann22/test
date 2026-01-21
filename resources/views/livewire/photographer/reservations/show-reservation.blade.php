<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <x-mary-header title="Reservation Details" subtitle="View reservation information and submit drive link">
            <x-slot:actions>
                <x-mary-button label="Back to List" link="{{ route('photographer.reservations.index') }}"
                    icon="o-arrow-left" class="btn-ghost" />
            </x-slot:actions>
        </x-mary-header>
    </div>

    {{-- Status Badge --}}
    <div class="mb-6">
        @php
            $statusColor = match ($reservationDetail->reservation->status) {
                App\Enums\ReservationStatus::Pending => 'badge-warning',
                App\Enums\ReservationStatus::Confirmed => 'badge-info',
                App\Enums\ReservationStatus::InProgress => 'badge-primary',
                App\Enums\ReservationStatus::Completed => 'badge-success',
                App\Enums\ReservationStatus::Cancelled => 'badge-error',
                default => 'badge-ghost',
            };
        @endphp
        <span class="badge {{ $statusColor }} badge-lg">
            {{ $reservationDetail->reservation->status->label() }}
        </span>
    </div>

    {{-- Reservation Info Card --}}
    <x-mary-card title="Booking Information" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Reservation Code</p>
                <p class="font-semibold">{{ $reservationDetail->reservation->reservation_code }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Customer Name</p>
                <p class="font-semibold">{{ $reservationDetail->reservation->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Customer Email</p>
                <p class="font-semibold">{{ $reservationDetail->reservation->user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Customer Phone</p>
                <p class="font-semibold">{{ $reservationDetail->reservation->user->phone ?? 'N/A' }}</p>
            </div>
        </div>
    </x-mary-card>

    {{-- Session Details Card --}}
    <x-mary-card title="Session Details" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">City</p>
                <p class="font-semibold">{{ $reservationDetail->city->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Moment</p>
                <p class="font-semibold">{{ $reservationDetail->moment->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Package</p>
                <p class="font-semibold">{{ $reservationDetail->package->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Date</p>
                <p class="font-semibold">{{ $reservationDetail->photoshoot_date->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Time</p>
                <p class="font-semibold">{{ $reservationDetail->photoshoot_time }} -
                    {{ $reservationDetail->end_time }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">PAX</p>
                <p class="font-semibold">{{ $reservationDetail->pax }} person(s)</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Location Type</p>
                <p class="font-semibold">{{ ucfirst($reservationDetail->location_type ?? 'N/A') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Location Details</p>
                <p class="font-semibold">{{ $reservationDetail->location_details ?? 'N/A' }}</p>
            </div>
        </div>

        @if ($reservationDetail->additional_info)
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">Additional Information</p>
                <p class="font-semibold">{{ $reservationDetail->additional_info }}</p>
            </div>
        @endif
    </x-mary-card>

    {{-- Drive Link Submission Card --}}
    <x-mary-card title="Photo Delivery" class="mb-6">
        @if ($reservationDetail->reservation->status === App\Enums\ReservationStatus::Completed)
            {{-- Already Completed --}}
            <div class="flex items-center gap-3 p-4 bg-success/10 rounded-lg border border-success/20">
                <x-mary-icon name="o-check-circle" class="w-8 h-8 text-success" />
                <div>
                    <p class="font-semibold text-success">Photos Delivered!</p>
                    <a href="{{ $reservationDetail->drive_link }}" target="_blank"
                        class="text-sm text-primary hover:underline flex items-center gap-1">
                        <x-mary-icon name="o-link" class="w-4 h-4" />
                        {{ $reservationDetail->drive_link }}
                    </a>
                </div>
            </div>
        @else
            {{-- Form to Submit Drive Link --}}
            <form wire:submit="submitDriveLink">
                <div class="space-y-4">
                    <x-mary-input label="Google Drive Link" placeholder="https://drive.google.com/..."
                        wire:model="drive_link" icon="o-link"
                        hint="Paste the Google Drive link containing the finished photos" error-field="drive_link" />

                    <div class="flex items-center gap-2 p-4 bg-warning/10 rounded-lg border border-warning/20">
                        <x-mary-icon name="o-exclamation-triangle" class="w-5 h-5 text-warning" />
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Submitting the drive link will automatically mark this reservation as
                            <strong>Completed</strong>.
                        </p>
                    </div>

                    <x-mary-button type="submit" label="Submit Drive Link" icon="o-paper-airplane" class="btn-primary"
                        spinner="submitDriveLink" />
                </div>
            </form>
        @endif
    </x-mary-card>
</div>
