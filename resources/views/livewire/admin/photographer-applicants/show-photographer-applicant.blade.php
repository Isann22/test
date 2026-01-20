<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('photographer-applicants-list') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mb-2">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-1" />
                Back to Applicants
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $record->fullname }}
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Applied {{ $record->created_at->format('d M Y H:i') }}
            </p>
        </div>

        {{-- Status Select --}}
        <div class="w-full sm:w-48">
            {{ $this->form }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Personal Info --}}
        <x-filament::section>
            <x-slot name="heading">Personal Information</x-slot>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Full Name</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">{{ $record->fullname }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $record->email }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Phone Number</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $record->phonenumber }}</dd>
                </div>
                <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                    <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                    <dd>
                        <x-filament::badge :color="match ($record->status?->value) {
                            'review' => 'warning',
                            'hired' => 'success',
                            'rejected' => 'danger',
                            default => 'gray',
                        }">
                            {{ $record->status?->label() ?? 'N/A' }}
                        </x-filament::badge>
                    </dd>
                </div>
            </dl>
        </x-filament::section>

        {{-- Social Links --}}
        <x-filament::section>
            <x-slot name="heading">Social Links</x-slot>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Instagram</dt>
                    <dd class="text-gray-900 dark:text-white">
                        @if ($record->instagram_link)
                            <a href="{{ $record->instagram_link }}" target="_blank"
                                class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 inline-flex items-center">
                                <x-heroicon-o-link class="w-4 h-4 mr-1" />
                                View Profile
                            </a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Portfolio</dt>
                    <dd class="text-gray-900 dark:text-white">
                        @if ($record->portofolio_link)
                            <a href="{{ $record->portofolio_link }}" target="_blank"
                                class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 inline-flex items-center">
                                <x-heroicon-o-globe-alt class="w-4 h-4 mr-1" />
                                View Portfolio
                            </a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </x-filament::section>
    </div>

    {{-- Equipment & Skills --}}
    <x-filament::section>
        <x-slot name="heading">Equipment & Skills</x-slot>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Cameras --}}
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400 mb-2">Cameras & Gear</dt>
                <dd class="flex flex-wrap gap-2">
                    @forelse($record->cameras ?? [] as $camera)
                        <x-filament::badge color="warning">{{ $camera }}</x-filament::badge>
                    @empty
                        <span class="text-gray-400 text-sm">No cameras listed</span>
                    @endforelse
                </dd>
            </div>

            {{-- Cities --}}
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400 mb-2">Service Areas (Cities)</dt>
                <dd class="flex flex-wrap gap-2">
                    @forelse($record->cities ?? [] as $city)
                        <x-filament::badge color="success">{{ $city }}</x-filament::badge>
                    @empty
                        <span class="text-gray-400 text-sm">No cities listed</span>
                    @endforelse
                </dd>
            </div>

            {{-- Moments/Specializations --}}
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400 mb-2">Specializations</dt>
                <dd class="flex flex-wrap gap-2">
                    @forelse($record->moments ?? [] as $moment)
                        <x-filament::badge color="info">{{ $moment }}</x-filament::badge>
                    @empty
                        <span class="text-gray-400 text-sm">No specializations listed</span>
                    @endforelse
                </dd>
            </div>
        </div>
    </x-filament::section>
</div>
