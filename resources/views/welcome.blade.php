<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Blood Donation') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100">
    <!-- Top Nav -->
    <header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/80 backdrop-blur dark:border-slate-800/70 dark:bg-slate-950/70">
        <div class="mx-auto max-w-6xl px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-600 text-white font-bold">
                    🩸
                </span>
                <div class="leading-tight">
                    <div class="font-semibold">{{ config('app.name', 'Blood Donation') }}</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Donate • Request • Save Lives</div>
                </div>
            </a>

            <nav class="flex items-center gap-2">
                <a href="{{ route('blood-requests.index') }}"
                    class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium border border-slate-200 hover:bg-slate-50
          dark:border-slate-800 dark:hover:bg-slate-900">
                    All Requests
                </a>
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}"
                    class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium bg-slate-900 text-white hover:bg-slate-800 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-white">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium border border-slate-200 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">
                    Log in
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium bg-red-600 text-white hover:bg-red-700">
                    Register
                </a>
                @endif
                @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <main>
        <section class="mx-auto max-w-6xl px-4 pt-10 pb-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-medium text-red-700 dark:border-red-900/40 dark:bg-red-950/30 dark:text-red-300">
                        <span class="h-2 w-2 rounded-full bg-red-600"></span>
                        Bangladesh Blood Donation Network
                    </div>

                    <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">
                        Find a donor fast. <span class="text-red-600">Request blood</span> instantly.
                    </h1>

                    <p class="mt-4 text-base text-slate-600 dark:text-slate-300">
                        A simple platform to connect donors and patients by location (Division → District → Upazila / Dhaka City Corp).
                        Post a request, match with nearby donors, and save lives.
                    </p>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('register') }}"
                            class="inline-flex justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700">
                            Become a Donor
                        </a>

                        <a href="{{ Route::has('blood-requests.create') ? route('blood-requests.create') : (Route::has('login') ? route('login') : '#') }}"
                            class="inline-flex justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">
                            Create Blood Request
                        </a>
                        <a href="{{ route('blood-requests.index') }}"
                            class="inline-flex justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold
          hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">
                            Browse All Requests
                        </a>
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-3">
                        <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                            <div class="text-xs text-slate-500 dark:text-slate-400">Response</div>
                            <div class="mt-1 text-lg font-semibold">Quick</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                            <div class="text-xs text-slate-500 dark:text-slate-400">Match by</div>
                            <div class="mt-1 text-lg font-semibold">Location</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                            <div class="text-xs text-slate-500 dark:text-slate-400">Trusted</div>
                            <div class="mt-1 text-lg font-semibold">Community</div>
                        </div>
                    </div>
                </div>

                <!-- Visual panel -->
                <div class="relative">
                    <div class="absolute -inset-3 rounded-3xl bg-gradient-to-br from-red-100 to-white blur-2xl dark:from-red-950/40 dark:to-slate-950"></div>

                    <div class="relative rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-sm font-semibold">Emergency Request</div>
                                <div class="mt-1 text-sm text-slate-600 dark:text-slate-300">
                                    Example preview (your real requests will appear in app pages)
                                </div>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-red-600 px-3 py-1 text-xs font-semibold text-white">
                                URGENT
                            </span>
                        </div>

                        <div class="mt-6 grid gap-3">
                            <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-medium">Blood Group</div>
                                    <div class="text-sm font-semibold text-red-600">B+</div>
                                </div>
                                <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                    Needed: 3 bags • Date: 2026-03-07
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                                <div class="text-sm font-medium">Location</div>
                                <div class="mt-2 text-sm text-slate-700 dark:text-slate-200">
                                    Dhaka • City Corporation Area
                                </div>
                                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    Matches donors within your selected area
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-900">
                                <div class="text-sm font-semibold">Next step</div>
                                <div class="mt-1 text-sm text-slate-600 dark:text-slate-300">
                                    Donors get notified & can respond quickly.
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2">
                            @php($groups = ['A+','A-','B+','B-','O+','O-','AB+','AB-'])
                            @foreach($groups as $g)
                            <span class="inline-flex items-center rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold dark:border-slate-800">
                                {{ $g }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section class="mx-auto max-w-6xl px-4 py-10">
            <h2 class="text-2xl font-bold">How it works</h2>
            <p class="mt-2 text-slate-600 dark:text-slate-300">
                Built for fast matching in Bangladesh location structure.
            </p>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 p-6 dark:border-slate-800">
                    <div class="text-sm font-semibold">1) Complete profile</div>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                        Add blood group, phone, and location (Division → District → Upazila / Dhaka City Corp).
                    </p>
                </div>

                <div class="rounded-3xl border border-slate-200 p-6 dark:border-slate-800">
                    <div class="text-sm font-semibold">2) Request blood</div>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                        Create a request with needed date, quantity, and hospital/address note (optional).
                    </p>
                </div>

                <div class="rounded-3xl border border-slate-200 p-6 dark:border-slate-800">
                    <div class="text-sm font-semibold">3) Match donors</div>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                        Notify matching donors nearby so they can respond quickly.
                    </p>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="mx-auto max-w-6xl px-4 pb-14">
            <div class="rounded-3xl bg-slate-900 p-8 text-white dark:bg-slate-100 dark:text-slate-900">
                <div class="grid gap-6 md:grid-cols-2 md:items-center">
                    <div>
                        <h3 class="text-2xl font-bold">Ready to save a life today?</h3>
                        <p class="mt-2 text-sm opacity-90">
                            Join as a donor or create a request. Every minute matters.
                        </p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row md:justify-end">
                        <a href="{{ route('register') }}"
                            class="inline-flex justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700 dark:bg-red-600 dark:text-white dark:hover:bg-red-700">
                            Register as Donor
                        </a>
                        <a href="{{ Route::has('login') ? route('login') : '#' }}"
                            class="inline-flex justify-center rounded-xl border border-white/30 px-5 py-3 text-sm font-semibold hover:bg-white/10 dark:border-slate-300 dark:hover:bg-slate-200">
                            Log in
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200/70 py-8 text-center text-sm text-slate-500 dark:border-slate-800/70 dark:text-slate-400">
        <div class="mx-auto max-w-6xl px-4">
            © {{ date('Y') }} {{ config('app.name', 'Blood Donation') }} • Built with Laravel
        </div>
    </footer>
</body>

</html>