<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">
                    {{ __('Profile') }}
                </h2>
                <p class="mt-1 text-sm text-slate-600">
                    Manage your account information and security.
                </p>
            </div>

            <div class="hidden sm:flex items-center gap-2 rounded-2xl border border-red-200/60 bg-red-50 px-3 py-2 text-sm text-red-700">
                <span class="inline-flex h-2 w-2 rounded-full bg-red-500"></span>
                Blood Donation
            </div>
        </div>
    </x-slot>

    <div class="relative">
        <!-- soft background glow -->
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-red-500/10 blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-red-500/10 blur-3xl"></div>
        </div>

        <div class="relative py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="space-y-6">
                    <!-- Update Profile Info -->
                    <div class="rounded-3xl border border-slate-200/70 bg-white p-5 shadow-sm sm:p-8">
                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <h3 class="text-base font-semibold text-slate-900">Profile Information</h3>
                                <p class="mt-1 text-sm text-slate-600">Update your name and email address.</p>
                            </div>
                        </div>

                        <div class="mt-6 max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Update Password -->
                    <div class="rounded-3xl border border-slate-200/70 bg-white p-5 shadow-sm sm:p-8">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Password</h3>
                            <p class="mt-1 text-sm text-slate-600">Use a strong password to keep your account secure.</p>
                        </div>

                        <div class="mt-6 max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Delete Account -->
                    <div class="rounded-3xl border border-red-200/60 bg-white p-5 shadow-sm sm:p-8">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Delete Account</h3>
                            <p class="mt-1 text-sm text-slate-600">
                                Permanently delete your account and all associated data.
                            </p>
                        </div>

                        <div class="mt-6 max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>