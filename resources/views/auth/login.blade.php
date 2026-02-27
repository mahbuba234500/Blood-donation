<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 py-10 bg-slate-50 dark:bg-slate-950">
        <div class="w-full max-w-lg">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="mx-auto mb-3 h-12 w-12 rounded-2xl bg-red-600 text-white flex items-center justify-center text-xl font-bold shadow-sm">
                    🩸
                </div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">
                    Welcome back
                </h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Log in to manage your donor profile and blood requests.
                </p>
            </div>

            <!-- Card -->
            <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-sm dark:bg-slate-900 dark:border-slate-800">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-700 dark:text-slate-200" />
                        <x-text-input
                            id="email"
                            class="mt-1 block w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-red-500 dark:focus:ring-red-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="name@example.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-slate-700 dark:text-slate-200" />
                        <x-text-input
                            id="password"
                            class="mt-1 block w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-red-500 dark:focus:ring-red-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Your password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember / Forgot -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center gap-2">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="rounded border-slate-300 text-red-600 shadow-sm focus:ring-red-500 dark:border-slate-700 dark:bg-slate-950"
                                name="remember"
                            >
                            <span class="text-sm text-slate-600 dark:text-slate-300">
                                {{ __('Remember me') }}
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                class="text-sm font-medium text-red-600 hover:text-red-700"
                                href="{{ route('password.request') }}"
                            >
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="pt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        @if (Route::has('register'))
                            <a
                                class="text-sm font-medium text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100"
                                href="{{ route('register') }}"
                            >
                                New here? Create an account
                            </a>
                        @endif

                        <button
                            type="submit"
                            class="inline-flex w-full sm:w-auto justify-center rounded-2xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                        >
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer note -->
            <p class="mt-6 text-center text-xs text-slate-500 dark:text-slate-400">
                Need help quickly? Create a blood request after login.
            </p>
        </div>
    </div>
</x-guest-layout>