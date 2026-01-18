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
            x-transition:leave-end="translate-x-full" class="fixed top-0 right-0 h-full w-60 bg-base-200 z-[999] shadow-xl"
            x-cloak>

            {{-- Close Button --}}
            <button @click="open = false" class="absolute top-4 right-4 btn btn-ghost btn-circle btn-sm">
                <x-mary-icon name="o-x-mark" class="w-5 h-5" />
            </button>

            <div class="p-0 pt-4">
                {{-- User Info --}}
                <div class="flex flex-col items-center gap-4 mb-2">
                    <div class="text-center">
                        <p class="font-semibold text-lg">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="divider"></div>

                {{-- Menu Items --}}
                <ul class="menu gap-2">
                    @if (!auth()->user()->hasVerifiedEmail())
                        <li>
                            <x-nav-link href="{{ route('verification.notice') }}" :active="request()->routeIs('verification.notice')" wire:navigate>
                                <x-mary-icon name="o-envelope" class="w-5 h-5" />
                                Verify Email
                            </x-nav-link>
                        </li>
                    @else
                        <li>
                            <x-mary-button label="Profile" icon="o-user" link="{{ route('settings') }}" class="w-full" />
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                @method('DELETE')
                                <x-mary-button label="Logout" icon="o-arrow-right-on-rectangle" class="w-full" />
                            </form>
                        </li>
                    @endif


                </ul>

            </div>


        </div>
    </div>
@endauth
