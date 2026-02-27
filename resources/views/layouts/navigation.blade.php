<nav x-data="{ open: false }"
    class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/70 backdrop-blur dark:border-slate-800 dark:bg-slate-900/60">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center justify-between">
            <!-- Left: Brand + Links -->
            <div class="flex items-center gap-6">
                <!-- Brand -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold shadow-sm">
                        🩸
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                            {{ config('app.name', 'Blood Donation') }}
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 -mt-0.5">
                            Find donors • Save lives
                        </div>
                    </div>
                </a>

                <!-- Desktop Links -->
                <div class="hidden sm:flex items-center gap-2">
                    <a href="{{ route('dashboard') }}"
                        class="px-3 py-2 rounded-2xl text-sm font-medium transition
                              {{ request()->routeIs('dashboard')
                                  ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300'
                                  : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 dark:text-slate-300 dark:hover:text-slate-100 dark:hover:bg-slate-800/60' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('blood-requests.index') }}"
                        class="px-3 py-2 rounded-2xl text-sm font-medium transition
          {{ request()->routeIs('blood-requests.index')
              ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 dark:text-slate-300 dark:hover:text-slate-100 dark:hover:bg-slate-800/60' }}">
                        📋 All Requests
                    </a>

                    <a href="{{ route('blood-requests.my') }}"
                        class="px-3 py-2 rounded-2xl text-sm font-medium transition
                              {{ request()->routeIs('blood-requests.my')
                                  ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300'
                                  : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 dark:text-slate-300 dark:hover:text-slate-100 dark:hover:bg-slate-800/60' }}">
                        My Requests
                    </a>
                </div>
            </div>

            <!-- Right: Auth / Guest -->
            <div class="hidden sm:flex items-center gap-3">
                @auth
                <div class="text-sm text-slate-600 dark:text-slate-300">
                    Hi, <span class="font-semibold text-slate-900 dark:text-slate-100">{{ auth()->user()->name }}</span>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium
                                       text-slate-700 shadow-sm transition hover:bg-slate-50
                                       focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                       dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800 dark:focus:ring-offset-slate-900">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                            </span>

                            <span class="hidden md:block">{{ __('Account') }}</span>

                            <svg class="h-4 w-4 opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('dashboard')">
                            Dashboard
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('blood-requests.my')">
                            My Requests
                        </x-dropdown-link>

                        <div class="my-1 border-t border-slate-200 dark:border-slate-700"></div>

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
                    class="text-sm font-medium text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-slate-100">
                    Login
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white
                                  hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                  dark:focus:ring-offset-slate-900">
                    Register
                </a>
                @endif
                @endguest
            </div>

            <!-- Mobile hamburger -->
            <div class="sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-2xl p-2 text-slate-600 hover:bg-slate-100/70 hover:text-slate-900
                               focus:outline-none focus:ring-2 focus:ring-red-500
                               dark:text-slate-300 dark:hover:bg-slate-800/60 dark:hover:text-slate-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="px-4 pb-4 pt-2 space-y-2">
            <a href="{{ route('dashboard') }}"
                class="block rounded-2xl px-3 py-2 text-sm font-medium
                      {{ request()->routeIs('dashboard')
                          ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300'
                          : 'text-slate-700 hover:bg-slate-100/70 dark:text-slate-200 dark:hover:bg-slate-800/60' }}">
                Dashboard
            </a>

            <a href="{{ route('blood-requests.index') }}"
                class="block rounded-2xl px-3 py-2 text-sm font-medium
          {{ request()->routeIs('blood-requests.index')
              ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300'
              : 'text-slate-700 hover:bg-slate-100/70 dark:text-slate-200 dark:hover:bg-slate-800/60' }}">
                Requests
            </a>

            <a href="{{ route('blood-requests.my') }}"
                class="block rounded-2xl px-3 py-2 text-sm font-medium
                      {{ request()->routeIs('blood-requests.my')
                          ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300'
                          : 'text-slate-700 hover:bg-slate-100/70 dark:text-slate-200 dark:hover:bg-slate-800/60' }}">
                My Requests
            </a>

            @auth
            <div class="mt-3 rounded-2xl border border-slate-200 bg-white p-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="font-semibold text-slate-900 dark:text-slate-100">{{ auth()->user()->name }}</div>
                <div class="text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</div>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700
                                       focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                       dark:focus:ring-offset-slate-900">
                        Log Out
                    </button>
                </form>
            </div>
            @endauth

            @guest
            <div class="mt-3 grid grid-cols-2 gap-2">
                <a href="{{ route('login') }}"
                    class="rounded-2xl border border-slate-200 bg-white px-3 py-2 text-center text-sm font-semibold text-slate-700
                              hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                    Login
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="rounded-2xl bg-red-600 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-red-700">
                    Register
                </a>
                @endif
            </div>
            @endguest
        </div>
    </div>
</nav>