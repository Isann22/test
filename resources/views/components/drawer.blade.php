<div class="drawer-side z-50">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4">
        <x-nav-link :active="request()->routeIs('home')" wire:navigate>
            Cities
        </x-nav-link>
    </ul>
</div>
