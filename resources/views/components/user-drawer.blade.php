@auth
    <div x-data="{ open: false }" @open-user-drawer.window="open = true">
        {{-- Hidden checkbox for label trigger --}}
        <input type="checkbox" id="user-drawer" class="hidden" x-model="open" />

        {{-- Overlay --}}
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="open = false" class="fixed inset-0 bg-black/50 z-[998]" x-cloak>
        </div>

        {{-- Drawer Panel --}}
        <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full" class="fixed top-0 right-0 h-full w-72 bg-base-100 z-[999] shadow-xl"
            x-cloak>

            {{-- Close Button --}}
            <button @click="open = false" class="absolute top-4 right-4 btn btn-ghost btn-circle btn-sm">
                <x-mary-icon name="o-x-mark" class="w-5 h-5" />
            </button>

            <div class="p-6 pt-14">
                {{-- User Info --}}
                <div class="flex flex-col items-center gap-3 mb-6">
                    <div class="avatar placeholder">
                        <div class="flex items-center justify-center bg-primary text-primary-content rounded-full w-16">
                            <span class="text-2xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-lg text-base-content">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-base-content/60">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="divider my-4"></div>

                {{-- Menu Items --}}
                <ul class="menu menu-lg p-0 gap-1">
                    @if (!auth()->user()->hasVerifiedEmail())
                        <li>
                            <a href="{{ route('verification.notice') }}" wire:navigate
                                class="{{ request()->routeIs('verification.notice') ? 'active' : '' }}">
                                <x-mary-icon name="o-envelope" class="w-5 h-5" />
                                Verify Email
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('settings') }}" wire:navigate
                                class="{{ request()->routeIs('settings') ? 'active' : '' }}">
                                <x-mary-icon name="o-user" class="w-5 h-5" />
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reserved.index') }}" wire:navigate
                                class="{{ request()->routeIs('reserved.index') ? 'active' : '' }}">
                                <x-mary-icon name="o-calendar-days" class="w-5 h-5" />
                                My Reservations
                            </a>
                        </li>
                    @endif
                </ul>

                {{-- Logout at bottom --}}
                @if (auth()->user()->hasVerifiedEmail())
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="divider my-4"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-ghost btn-block justify-start text-error hover:bg-error/10">
                                <x-mary-icon name="o-arrow-right-on-rectangle" class="w-5 h-5" />
                                Logout
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endauth
