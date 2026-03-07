<nav x-data="{ open: false }"
    class="sticky top-0 z-40 border-b border-white/70 bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/70">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-18 min-h-[72px] items-center justify-between gap-4">
            <!-- Left -->
            <div class="flex items-center gap-8">
                <a href="{{ auth()->check() ? route('dashboard') : route('landingPage') }}" class="group flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-600 text-lg text-white shadow-sm shadow-red-200/60 transition group-hover:scale-[1.02]">
                        🩸
                    </div>

                    <div class="hidden sm:block leading-tight">
                        <div class="text-sm font-semibold tracking-tight text-slate-900 transition group-hover:text-red-600">
                            {{ config('app.name', 'Blood Donation') }}
                        </div>
                        <div class="mt-0.5 text-xs text-slate-500">
                            Find donors with clarity and care
                        </div>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-1.5">
                    <a href="{{ route('donors.index') }}"
                        class="rounded-full px-4 py-2 text-sm font-medium transition
                        {{ request()->routeIs('donors.index')
                            ? 'bg-red-50 text-red-700 ring-1 ring-red-100'
                            : 'text-slate-600 hover:bg-rose-50 hover:text-slate-900' }}">
                        Find Donor
                    </a>

                    <a href="{{ route('blood-requests.index') }}"
                        class="rounded-full px-4 py-2 text-sm font-medium transition
                        {{ request()->routeIs('blood-requests.index')
                            ? 'bg-red-50 text-red-700 ring-1 ring-red-100'
                            : 'text-slate-600 hover:bg-rose-50 hover:text-slate-900' }}">
                        All Requests
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="rounded-full px-4 py-2 text-sm font-medium transition
                            {{ request()->routeIs('dashboard')
                                ? 'bg-red-50 text-red-700 ring-1 ring-red-100'
                                : 'text-slate-600 hover:bg-rose-50 hover:text-slate-900' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('blood-requests.my') }}"
                            class="rounded-full px-4 py-2 text-sm font-medium transition
                            {{ request()->routeIs('blood-requests.my')
                                ? 'bg-red-50 text-red-700 ring-1 ring-red-100'
                                : 'text-slate-600 hover:bg-rose-50 hover:text-slate-900' }}">
                            My Requests
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Right -->
            <div class="hidden sm:flex items-center gap-3">
                @auth
                    <div class="hidden md:block text-sm text-slate-500">
                        Welcome,
                        <span class="font-semibold text-slate-800">{{ auth()->user()->name }}</span>
                    </div>

                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-3 rounded-full border border-rose-100 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-rose-200 hover:bg-rose-50/60 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-rose-50 font-semibold text-red-700 ring-1 ring-rose-100">
                                    {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                                </span>

                                <span class="hidden md:block">Account</span>

                                <svg class="h-4 w-4 opacity-60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')">
                                Dashboard
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('donors.index')">
                                Find Donor
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('blood-requests.index')">
                                All Requests
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('blood-requests.my')">
                                My Requests
                            </x-dropdown-link>

                            <div class="my-1 border-t border-slate-100"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="rounded-full px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-rose-50 hover:text-slate-900">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center rounded-full bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-red-200/70 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Become a Donor
                        </a>
                    @endif
                @endguest
            </div>

            <!-- Mobile toggle -->
            <div class="sm:hidden">
                <button @click="open = !open"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-rose-100 bg-white text-slate-600 shadow-sm transition hover:bg-rose-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-cloak :class="{ 'block': open, 'hidden': !open }" class="hidden border-t border-rose-100 bg-white/95 sm:hidden">
        <div class="space-y-2 px-4 py-4">
            <a href="{{ route('donors.index') }}"
                class="block rounded-2xl px-4 py-3 text-sm font-medium transition
                {{ request()->routeIs('donors.index')
                    ? 'bg-red-50 text-red-700'
                    : 'text-slate-700 hover:bg-rose-50' }}">
                Find Donor
            </a>

            <a href="{{ route('blood-requests.index') }}"
                class="block rounded-2xl px-4 py-3 text-sm font-medium transition
                {{ request()->routeIs('blood-requests.index')
                    ? 'bg-red-50 text-red-700'
                    : 'text-slate-700 hover:bg-rose-50' }}">
                All Requests
            </a>

            @auth
                <a href="{{ route('dashboard') }}"
                    class="block rounded-2xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('dashboard')
                        ? 'bg-red-50 text-red-700'
                        : 'text-slate-700 hover:bg-rose-50' }}">
                    Dashboard
                </a>

                <a href="{{ route('blood-requests.my') }}"
                    class="block rounded-2xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('blood-requests.my')
                        ? 'bg-red-50 text-red-700'
                        : 'text-slate-700 hover:bg-rose-50' }}">
                    My Requests
                </a>

                <div class="mt-4 rounded-3xl border border-rose-100 bg-rose-50/40 p-4">
                    <div class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</div>
                    <div class="mt-1 text-sm text-slate-500">{{ auth()->user()->email }}</div>

                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit"
                            class="w-full rounded-2xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">
                            Log Out
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}"
                        class="rounded-2xl border border-rose-100 bg-white px-4 py-3 text-center text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-rose-50">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="rounded-2xl bg-red-600 px-4 py-3 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">
                            Register
                        </a>
                    @endif
                </div>
            @endguest
        </div>
    </div>
</nav>