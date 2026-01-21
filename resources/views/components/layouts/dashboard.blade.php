<!DOCTYPE html>
<html data-theme="lofi" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.bunny.net/css?family=inter:200,300,400,500,600,700,800" rel="stylesheet" />

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/filament.js'])
</head>

<body class="min-h-screen font-sans antialiased">

    <x-mary-nav class="bg-base-200" sticky full-width>

        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>

            {{-- Brand --}}
            <div>
                <a href="/" wire:navigate class="text-sm lg:text-xl font-bold btn btn-ghost normal-case px-2">
                    {{ config('app.name') }}
                </a>
            </div>
        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
            <x-mary-button label="Messages" icon="o-envelope" link="###" class="btn-ghost btn-sm" responsive />
            <x-mary-button label="Notifications" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive />
        </x-slot:actions>
    </x-mary-nav>

    {{-- The main content with `full-width` --}}
    <x-mary-main with-nav full-width>

        {{-- This is a sidebar that works also as a drawer on small screens --}}
        {{-- Notice the `main-drawer` reference here --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">

            {{-- User --}}
            @if ($user = auth()->user())
                <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                    class="pt-2 ps-10">
                    <x-slot:actions>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            @method('DELETE')
                            <x-mary-button type="submit" icon="o-power" tooltip-left="Logout"
                                class="btn-circle btn-ghost btn-xs" />

                        </form>
                    </x-slot:actions>
                </x-mary-list-item>

                <x-mary-menu-separator />
            @endif

            <x-mary-menu>

                <x-mary-menu-item title="Dashboard" icon="o-home" link="{{ route('admin.dashboard') }}"
                    :active="Route::is('admin.dashboard')" />

                <x-mary-menu-separator />

                <x-mary-menu-item title="Reservations" icon="o-calendar-days"
                    link="{{ route('admin.reservations.index') }}" :active="Route::is('admin.reservations.*')" />

                <x-mary-menu-item title="Cities" icon="o-map-pin" link="{{ route('cities.list') }}" :active="Route::is('cities.*')" />

                <x-mary-menu-item title="Moments" icon="o-sparkles" link="{{ route('moments.list') }}"
                    :active="Route::is('moments.*')" />

                <x-mary-menu-item title="Packages" icon="o-cube" wire-navigate
                    link="{{ route('admin.packages.index') }}" :active="Route::is('admin.packages.*')" />

                <x-mary-menu-item title="Photographers" icon="o-camera" wire-navigate
                    link="{{ route('admin.photographers.index') }}" :active="Route::is('admin.photographers.*')" />

                <x-mary-menu-separator />

                <x-mary-menu-sub title="Applicants" icon="o-user-group">
                    <x-mary-menu-item title="Photographer" icon="o-identification"
                        link="{{ route('photographer-applicants-list') }}" :active="Route::is('photographer-applicants-list') ||
                            Route::is('photographers-applicant-view')" />
                </x-mary-menu-sub>
            </x-mary-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>
    @livewire('notifications')


    @livewireScripts
    @filamentScripts
</body>

</html>
