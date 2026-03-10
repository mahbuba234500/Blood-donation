@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen bg-slate-50">
        <!-- Soft background glow -->
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-red-500/10 blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-red-500/10 blur-3xl"></div>
        </div>

        <div class="relative py-8 sm:py-10">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <!-- Back -->
                <div class="mb-6">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-red-600">
                        <span>←</span>
                        <span>Back</span>
                    </a>
                </div>

                <!-- Header Card -->
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                <span
                                    class="inline-flex rounded-xl bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">
                                    {{ $bloodRequest->blood_group }}
                                </span>

                                @if ($bloodRequest->is_emergency)
                                    <span
                                        class="inline-flex rounded-xl bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                        Emergency
                                    </span>
                                @endif

                                <span
                                    class="inline-flex rounded-xl bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                    {{ ucfirst($bloodRequest->status) }}
                                </span>
                            </div>

                            <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                                Blood needed for {{ $bloodRequest->patient_name }}
                            </h1>

                            <p class="mt-2 text-sm text-slate-600">
                                Requested by {{ $bloodRequest->requester_name }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Needed Date</p>
                            <p class="mt-2 text-base font-semibold text-slate-900">
                                {{ \Carbon\Carbon::parse($bloodRequest->needed_date)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
                    <!-- Main -->
                    <div class="space-y-6 xl:col-span-2">
                        <!-- Request Details -->
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Request Details</h2>

                            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Patient Name</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">{{ $bloodRequest->patient_name }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Blood Group</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">{{ $bloodRequest->blood_group }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Quantity</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">
                                        {{ $bloodRequest->quantity_bags ?? 1 }} bag(s)
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Needed On</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">
                                        {{ \Carbon\Carbon::parse($bloodRequest->needed_date)->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 p-4 sm:col-span-2">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Hospital</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">
                                        {{ $bloodRequest->hospital_name ?: 'Not provided' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Location</h2>

                            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Division</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">
                                        {{ $bloodRequest->division?->name ?? 'Not provided' }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">District</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">
                                        {{ $bloodRequest->district?->name ?? 'Not provided' }}
                                    </p>
                                </div>

                                @if ($bloodRequest->upazilla)
                                    <div class="rounded-2xl bg-slate-50 p-4">
                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Upazila / Thana
                                        </p>
                                        <p class="mt-2 text-base font-semibold text-slate-900">
                                            {{ $bloodRequest->upazilla->name }}
                                        </p>
                                    </div>
                                @endif

                                @if ($bloodRequest->cityCorporation)
                                    <div class="rounded-2xl bg-slate-50 p-4">
                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">City Corporation
                                        </p>
                                        <p class="mt-2 text-base font-semibold text-slate-900">
                                            {{ $bloodRequest->cityCorporation->name }}
                                        </p>
                                    </div>
                                @endif

                                @if ($bloodRequest->cityArea)
                                    <div class="rounded-2xl bg-slate-50 p-4 sm:col-span-2">
                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">City Area</p>
                                        <p class="mt-2 text-base font-semibold text-slate-900">
                                            {{ $bloodRequest->cityArea->name }}
                                        </p>
                                    </div>
                                @endif

                                @if ($bloodRequest->address_line)
                                    <div class="rounded-2xl bg-slate-50 p-4 sm:col-span-2">
                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Address</p>
                                        <p class="mt-2 text-base font-semibold text-slate-900">
                                            {{ $bloodRequest->address_line }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Notes -->
                        @if ($bloodRequest->note)
                            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                <h2 class="text-lg font-semibold text-slate-900">Additional Note</h2>
                                <p class="mt-4 text-sm leading-7 text-slate-600">
                                    {{ $bloodRequest->note }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Contact -->
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Requester Contact</h2>

                            <div class="mt-5 space-y-4">
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Name</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">
                                        {{ $bloodRequest->requester_name }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Phone</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">
                                        {{ $bloodRequest->requester_phone }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="tel:{{ $bloodRequest->requester_phone }}"
                                    class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">
                                    Call Requester
                                </a>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="rounded-3xl border border-red-100 bg-gradient-to-br from-red-50 to-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Request Status</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Track the urgency and current state of this blood request.
                            </p>

                            <div class="mt-5 rounded-2xl bg-white/80 p-4 space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-500">Status</span>
                                    <span class="font-semibold text-slate-900">{{ ucfirst($bloodRequest->status) }}</span>
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-500">Emergency</span>
                                    <span
                                        class="font-semibold text-slate-900">{{ $bloodRequest->is_emergency ? 'Yes' : 'No' }}</span>
                                </div>

                                @if ($bloodRequest->expires_at)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Expires At</span>
                                        <span class="font-semibold text-slate-900">
                                            {{ \Carbon\Carbon::parse($bloodRequest->expires_at)->format('d M Y, h:i A') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Owner Actions -->
                        @auth
                            @if (auth()->id() === $bloodRequest->requester_user_id && $bloodRequest->status === 'pending')
                                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                    <h2 class="text-lg font-semibold text-slate-900">Manage Request</h2>

                                    <div class="mt-5 space-y-3">
                                        <form method="POST" action="{{ route('blood-requests.complete', $bloodRequest) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                                                Mark as Completed
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('blood-requests.cancel', $bloodRequest) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                                                Cancel Request
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
