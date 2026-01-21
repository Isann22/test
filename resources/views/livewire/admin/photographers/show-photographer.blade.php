<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.photographers.index') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mb-2">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-1" />
                Back to Photographers
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $photographer->name }}
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Joined {{ $photographer->created_at->format('d M Y') }}
            </p>
        </div>

        {{-- Status Badge --}}
        <div>
            <x-filament::badge :color="$photographer->photographerProfile->is_active ? 'success' : 'danger'">
                {{ $photographer->photographerProfile->is_active ? 'Active' : 'Inactive' }}
            </x-filament::badge>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Personal Info --}}
        <x-filament::section>
            <x-slot name="heading">Personal Information</x-slot>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Full Name</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">{{ $photographer->name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $photographer->email }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Phone Number</dt>
                    <dd class="text-gray-900 dark:text-white">{{ $photographer->phone_number ?? '-' }}</dd>
                </div>
                @if ($photographer->photographerProfile->rating)
                    <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                        <dt class="text-gray-500 dark:text-gray-400">Rating</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">
                            {{ number_format($photographer->photographerProfile->rating, 1) }} ⭐
                        </dd>
                    </div>
                @endif
            </dl>
        </x-filament::section>

        {{-- Social Links --}}
        <x-filament::section>
            <x-slot name="heading">Social Links</x-slot>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Instagram</dt>
                    <dd class="text-gray-900 dark:text-white">
                        @if ($photographer->photographerProfile->instagram_link)
                            <a href="{{ $photographer->photographerProfile->instagram_link }}" target="_blank"
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
                        @if ($photographer->photographerProfile->portofolio_link)
                            <a href="{{ $photographer->photographerProfile->portofolio_link }}" target="_blank"
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
                    @forelse($photographer->photographerProfile->cameras ?? [] as $camera)
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
                    @forelse($photographer->photographerProfile->cities ?? [] as $city)
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
                    @forelse($photographer->photographerProfile->moments ?? [] as $moment)
                        <x-filament::badge color="info">{{ $moment }}</x-filament::badge>
                    @empty
                        <span class="text-gray-400 text-sm">No specializations listed</span>
                    @endforelse
                </dd>
            </div>
        </div>
    </x-filament::section>
</div>
