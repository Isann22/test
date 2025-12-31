<!DOCTYPE html>
<html data-theme="corporate" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

<body class="min-h-svh antialiased font-inter bg-white text-black flex flex-col">
    <main class="flex-1 relative   text-black flex flex-col justify-center items-center">


        <div class="flex relative z-10 p-0 xl:p-2 rounded-2xl shadow-md bg-white w-96 my-4 lg:my-0 2xl:w-8/12">
            {{ $slot }}
        </div>
    </main>
    <x-toaster-hub />
    @livewireScriptConfig

    @stack('scripts')
</body>

</html>
