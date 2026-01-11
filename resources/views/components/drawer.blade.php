<div class="drawer-side z-50">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4">
        <a href="/" wire:navigate class="text-xl font-bold normal-case px-2">
            {{ config('app.name') }}
        </a>
        <x-nav-link href="{{ route('destinations.index') }}" :active="request()->routeIs('destinations.index')" wire:navigate>
            Cities
        </x-nav-link>
        <x-nav-link href="{{ route('moments.index') }}" :active="request()->routeIs('moments.index')" wire:navigate>
            Moments
        </x-nav-link>
        <x-nav-link href="{{ route('photographer.index') }}" :active="request()->routeIs('photographer.index')" wire:navigate>
            Photographer
        </x-nav-link>
    </ul>
</div>
