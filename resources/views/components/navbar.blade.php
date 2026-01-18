<x-mary-nav sticky full-width class="z-50 border-b border-base-200">

    <x-slot:brand>
        <div class="flex items-center gap-4">

            <label for="my-drawer-2" class="lg:hidden cursor-pointer btn btn-ghost btn-circle btn-sm">
                <x-mary-icon name="o-bars-3" class="w-6 h-6" />
            </label>

            <a href="/" wire:navigate class="text-sm lg:text-xl font-bold btn btn-ghost normal-case px-2">
                {{ config('app.name') }}
            </a>

            <div class="hidden lg:flex items-center gap-1 ml-4">
                <ul class="menu menu-horizontal px-1">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" wire:navigate>
                        Home
                    </x-nav-link>
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
        </div>
    </x-slot:brand>

    <x-slot:actions>
        <div class="flex items-center gap-3">
            <div class="relative">
                <input type="text"
                    class="bg-base-200 h-10 px-5 pr-10 rounded-full text-sm focus:outline-none transition-all duration-300 ease-in-out w-10 focus:w-48 md:w-12 md:focus:w-64 cursor-pointer focus:cursor-text"
                    placeholder="Search..."
                    onfocus="this.classList.remove('w-10', 'md:w-12', 'cursor-pointer'); this.classList.add('w-48', 'md:w-64', 'cursor-text');"
                    onblur="if(this.value === '') { this.classList.remove('w-48', 'md:w-64', 'cursor-text'); this.classList.add('w-10', 'md:w-12', 'cursor-pointer'); }">
                <button
                    class="absolute right-0 top-0 h-10 w-10 flex items-center justify-center pointer-events-none text-base-content/50">
                    <x-mary-icon name="o-magnifying-glass" class="w-4 h-4" />
                </button>
            </div>

            <div class="flex gap-2">
                @guest
                    <x-mary-button label="Log in" link="{{ route('login') }}" class="btn-neutral btn-sm" />

                @endguest

                @auth
                    <label for="user-drawer" class="btn btn-circle btn-ghost btn-sm cursor-pointer avatar placeholder">
                        <div class="bg-primary text-primary-content rounded-full w-8 flex items-center justify-center">
                            <span class="text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    </label>
                @endauth
            </div>

        </div>
    </x-slot:actions>

</x-mary-nav>
