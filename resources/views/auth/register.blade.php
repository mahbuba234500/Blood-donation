<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 py-10 bg-slate-50 dark:bg-slate-950">
        <div class="w-full max-w-lg">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="mx-auto mb-3 h-12 w-12 rounded-2xl bg-red-600 text-white flex items-center justify-center text-xl font-bold shadow-sm">
                    🩸
                </div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">
                    Create your account
                </h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Join as a donor and help save lives.
                </p>
            </div>

            <!-- Card -->
            <div class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-sm dark:bg-slate-900 dark:border-slate-800">
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" class="text-slate-700 dark:text-slate-200" />
                        <x-text-input
                            id="name"
                            class="mt-1 block w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-red-500 dark:focus:ring-red-500"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="e.g. MD. Mamun Ur Rashid"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

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
                            autocomplete="username"
                            placeholder="e.g. name@example.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <x-input-label for="phone" :value="__('Phone')" class="text-slate-700 dark:text-slate-200" />
                        <x-text-input
                            id="phone"
                            class="mt-1 block w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-red-500 dark:focus:ring-red-500"
                            type="tel"
                            name="phone"
                            :value="old('phone')"
                            required
                            autocomplete="tel"
                            placeholder="e.g. 01XXXXXXXXX"
                        />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
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
                            autocomplete="new-password"
                            placeholder="Minimum 8 characters"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-slate-700 dark:text-slate-200" />
                        <x-text-input
                            id="password_confirmation"
                            class="mt-1 block w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-red-500 dark:focus:ring-red-500"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Re-type your password"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Actions -->
                    <div class="pt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <a
                            class="text-sm font-medium text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100"
                            href="{{ route('login') }}"
                        >
                            Already registered?
                        </a>

                        <button
                            type="submit"
                            class="inline-flex w-full sm:w-auto justify-center rounded-2xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                        >
                            Register
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer note -->
            <p class="mt-6 text-center text-xs text-slate-500 dark:text-slate-400">
                By creating an account, you agree to help responsibly and share accurate information.
            </p>
        </div>
    </div>
</x-guest-layout>