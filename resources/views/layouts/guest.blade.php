<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blood Donation') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>[x-cloak]{ display:none !important; }</style>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">

    <!-- Soft background glow -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-red-500/10 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-red-500/10 blur-3xl"></div>
    </div>

    <div class="relative min-h-screen flex flex-col justify-center items-center px-4 py-10">

        <!-- Logo -->
        <div class="mb-6">
            <a href="/" class="flex flex-col items-center gap-3">
                <x-application-logo class="h-16 w-16 text-red-600" />
                <span class="text-lg font-semibold tracking-tight">
                    {{ config('app.name', 'Blood Donation') }}
                </span>
            </a>
        </div>

        <!-- Card Container -->
        <div class="w-full max-w-md">
            <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-sm dark:bg-slate-900 dark:border-slate-800">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <p class="mt-8 text-xs text-slate-500 dark:text-slate-400 text-center">
            Donate blood. Save lives. 🩸
        </p>
    </div>

</body>
</html>