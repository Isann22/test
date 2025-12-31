<div class="min-h-svh text-white flex items-center justify-center p-10">

    <div class="z-10 container mx-auto max-w-6xl  shadow-xl rounded-lg overflow-hidden md:flex">
        <div class="w-full p-8 md:p-12 space-y-8">

            @auth
                <div class="space-y-4">
                    <p class="text-lg text-gray-300 text-center">
                        Welcome to <span class="font-semibold text-blue-400">{{ config('app.name') }}</span>, <span
                            class="text-white">{{ auth()->user()->name }}
                            {{ auth()->user()->surname }}</span>!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @if (!auth()->user()->hasVerifiedEmail())
                            <a href="{{ route('verification.notice') }}" wire:navigate.hover
                                class="btn-primary w-full px-4 py-2 text-center">
                                Verify Email
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary w-full px-4 py-2 text-center">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
            @guest
                <div class="flex flex-col space-y-4">
                    <a href="{{ route('login') }}" wire:navigate.hover
                        class="bg-base-300 text-neutral font-semibold w-full px-4 py-2 text-center">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" wire:navigate.hover class="btn-primary w-full px-4 py-2 text-center">
                        Register
                    </a>
                </div>
            @endguest
        </div>


    </div>
</div>
