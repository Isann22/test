<div class="navbar bg-base-100 w-full shadow-sm sticky top-0 z-50">
    <div class="navbar-start gap-4">
        <div class="flex-none lg:hidden">
            <label for="my-drawer-2" aria-label="open sidebar" class="btn btn-square btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block h-6 w-6 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </label>
        </div>

        <a href="/" class="btn btn-ghost text-xl normal-case px-0">{{ config('app.name') }}</a>

        <div class="relative hidden sm:block">
            <input type="text" placeholder="Search events..."
                class="input input-bordered input-sm w-full md:w-64 focus:outline-none focus:border-primary transition-all" />
        </div>
    </div>

    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">

        </ul>
    </div>

    <div class="navbar-end gap-2">
        <div class="dropdown dropdown-end sm:hidden">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div tabindex="0"
                class="dropdown-content z-[1] p-2 shadow bg-base-100 rounded-box w-72 mt-4 border border-base-200">
                <input type="text" placeholder="Search." class="input input-bordered input-sm w-full" autofocus />
            </div>
        </div>

        @guest
            <a href="{{ route('login') }}" wire:navigate.hover class="btn btn-neutral btn-sm text-base-100">
                Log in
            </a>
            <a href="{{ route('register') }}" wire:navigate.hover class="btn  btn-sm text-neutral">
                Register
            </a>
        @endguest

        @auth
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost">
                    <span class="hidden md:inline font-normal mr-1">{{ auth()->user()->name }}</span>
                    <div class="avatar placeholder">
                        <div class="bg-neutral text-neutral-content rounded-full w-8">
                            <span>{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                </div>
                <div tabindex="0"
                    class="dropdown-content z-[1] card card-compact w-64 p-2 shadow bg-base-100 text-primary-content border border-base-200 mt-3">
                    <div class="card-body">
                        <div class="flex flex-col gap-2">
                            @if (!auth()->user()->hasVerifiedEmail())
                                <a href="{{ route('verification.notice') }}" wire:navigate.hover
                                    class="btn btn-warning btn-sm w-full">
                                    Verify Email
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm w-full">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</div>
