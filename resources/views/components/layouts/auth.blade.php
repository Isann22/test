<!DOCTYPE html>
<html data-theme="lofi" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:200,300,400,500,600,700,800" rel="stylesheet" />

    <title>{{ $title ?? config('app.name') }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@20.3.0/build/css/intlTelInput.css">

</head>

<body class="min-h-svh antialiased font-inter flex flex-col">
    <main>
        <div class="drawer">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col min-h-screen">

                <x-navbar />

                <div class="flex-1 flex items-center justify-center py-8">
                    <main class="w-full max-w-md px-4">
                        {{ $slot }}
                    </main>
                </div>
            </div>

            <x-drawer />
        </div>
    </main>
    <x-footer />

    <x-user-drawer />

    <x-toaster-hub />

    @stack('scripts')
    @livewireScriptConfig
</body>

</html>
