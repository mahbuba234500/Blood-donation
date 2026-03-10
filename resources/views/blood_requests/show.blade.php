@extends('layouts.app')

@section('content')
    @php
        $isOwner = auth()->check() && auth()->id() === $bloodRequest->requester_user_id;
        $currentUser = auth()->user();

        $rawPhone = $bloodRequest->requester_phone;
        $cleanPhone = preg_replace('/\D+/', '', $rawPhone);

        if (str_starts_with($cleanPhone, '0')) {
            $whatsAppPhone = '88' . $cleanPhone;
        } elseif (str_starts_with($cleanPhone, '880')) {
            $whatsAppPhone = $cleanPhone;
        } else {
            $whatsAppPhone = $cleanPhone;
        }

        $whatsAppMessage = urlencode(
            "Assalamu Alaikum / Adab, I saw your blood request for {$bloodRequest->patient_name}. I may be able to help. Please share the exact location and urgency."
        );

        $matchesBloodGroup = auth()->check()
            && $currentUser->blood_group
            && $currentUser->blood_group === $bloodRequest->blood_group;

        $matchesDivision = auth()->check()
            && $currentUser->division_id
            && (int) $currentUser->division_id === (int) $bloodRequest->division_id;

        $matchesDistrict = auth()->check()
            && $currentUser->district_id
            && (int) $currentUser->district_id === (int) $bloodRequest->district_id;

        $matchesUpazilla = auth()->check()
            && $currentUser->upazilla_id
            && $bloodRequest->upazilla_id
            && (int) $currentUser->upazilla_id === (int) $bloodRequest->upazilla_id;

        $matchesCityCorporation = auth()->check()
            && $currentUser->city_corporation_id
            && $bloodRequest->city_corporation_id
            && (int) $currentUser->city_corporation_id === (int) $bloodRequest->city_corporation_id;

        $matchesCityArea = auth()->check()
            && $currentUser->city_area_id
            && $bloodRequest->city_area_id
            && (int) $currentUser->city_area_id === (int) $bloodRequest->city_area_id;

        $matchLabel = null;
        $matchColor = null;

        if (!$isOwner && $matchesBloodGroup) {
            if ($matchesUpazilla || $matchesCityArea) {
                $matchLabel = 'Best match for you';
                $matchColor = 'bg-red-100 text-red-700 ring-red-200';
            } elseif ($matchesDistrict || $matchesCityCorporation) {
                $matchLabel = 'Strong match';
                $matchColor = 'bg-amber-100 text-amber-700 ring-amber-200';
            } else {
                $matchLabel = 'Matches your blood group';
                $matchColor = 'bg-emerald-100 text-emerald-700 ring-emerald-200';
            }
        }

        $matchReasons = [];
        if ($matchesBloodGroup) $matchReasons[] = 'Blood Group';
        if ($matchesDivision) $matchReasons[] = 'Division';
        if ($matchesDistrict) $matchReasons[] = 'District';
        if ($matchesUpazilla) $matchReasons[] = 'Upazilla';
        if ($matchesCityCorporation) $matchReasons[] = 'City Corporation';
        if ($matchesCityArea) $matchReasons[] = 'City Area';
    @endphp

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
                                <span class="inline-flex rounded-xl bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">
                                    {{ $bloodRequest->blood_group }}
                                </span>

                                @if ($bloodRequest->is_emergency)
                                    <span class="inline-flex rounded-xl bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                        Emergency
                                    </span>
                                @endif

                                <span class="inline-flex rounded-xl bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                    {{ ucfirst($bloodRequest->status) }}
                                </span>

                                @if ($isOwner)
                                    <span class="inline-flex rounded-xl bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700 ring-1 ring-sky-200">
                                        Your Request
                                    </span>
                                @elseif ($matchLabel)
                                    <span class="inline-flex rounded-xl px-3 py-1 text-xs font-semibold ring-1 {{ $matchColor }}">
                                        {{ $matchLabel }}
                                    </span>
                                @endif
                            </div>

                            <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                                Blood needed for {{ $bloodRequest->patient_name }}
                            </h1>

                            <p class="mt-2 text-sm text-slate-600">
                                Requested by {{ $bloodRequest->requester_name }}
                            </p>

                            @if (!$isOwner && $matchesBloodGroup && count($matchReasons))
                                <div class="mt-4 inline-flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs text-slate-600">
                                    <span class="font-semibold text-slate-800">Matches you:</span>
                                    @foreach ($matchReasons as $reason)
                                        <span class="rounded-full bg-white px-2.5 py-1 font-medium text-slate-700 ring-1 ring-slate-200">
                                            {{ $reason }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            @if ($isOwner)
                                <div class="mt-4 rounded-2xl border border-sky-100 bg-sky-50 px-4 py-3 text-sm text-sky-800">
                                    This is your own blood request. You can review details, contact updates, or manage its status from this page.
                                </div>
                            @endif
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
                        @if (!$isOwner && $matchesBloodGroup)
                            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                <h2 class="text-lg font-semibold text-slate-900">Why this request matches you</h2>
                                <p class="mt-2 text-sm leading-6 text-slate-600">
                                    This request is relevant to you based on your donor profile and saved location.
                                </p>

                                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    <div class="rounded-2xl bg-slate-50 p-4">
                                        <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Blood Group</div>
                                        <div class="mt-2 text-sm font-semibold {{ $matchesBloodGroup ? 'text-emerald-700' : 'text-slate-900' }}">
                                            {{ $matchesBloodGroup ? 'Matched' : 'Not matched' }}
                                        </div>
                                    </div>

                                    <div class="rounded-2xl bg-slate-50 p-4">
                                        <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Division</div>
                                        <div class="mt-2 text-sm font-semibold {{ $matchesDivision ? 'text-emerald-700' : 'text-slate-900' }}">
                                            {{ $matchesDivision ? 'Matched' : 'Not matched' }}
                                        </div>
                                    </div>

                                    <div class="rounded-2xl bg-slate-50 p-4">
                                        <div class="text-xs font-medium uppercase tracking-wide text-slate-500">District</div>
                                        <div class="mt-2 text-sm font-semibold {{ $matchesDistrict ? 'text-emerald-700' : 'text-slate-900' }}">
                                            {{ $matchesDistrict ? 'Matched' : 'Not matched' }}
                                        </div>
                                    </div>

                                    <div class="rounded-2xl bg-slate-50 p-4">
                                        <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Area Precision</div>
                                        <div class="mt-2 text-sm font-semibold {{ ($matchesUpazilla || $matchesCityCorporation || $matchesCityArea) ? 'text-emerald-700' : 'text-slate-900' }}">
                                            @if ($matchesCityArea)
                                                City Area matched
                                            @elseif ($matchesCityCorporation)
                                                City Corporation matched
                                            @elseif ($matchesUpazilla)
                                                Upazilla matched
                                            @else
                                                No precise area match
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Request Details -->
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Request Details</h2>

                            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Patient Name</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">{{ $bloodRequest->patient_name }}</p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Blood Group</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">{{ $bloodRequest->blood_group }}</p>
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
                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Upazila / Thana</p>
                                        <p class="mt-2 text-base font-semibold text-slate-900">
                                            {{ $bloodRequest->upazilla->name }}
                                        </p>
                                    </div>
                                @endif

                                @if ($bloodRequest->cityCorporation)
                                    <div class="rounded-2xl bg-slate-50 p-4">
                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">City Corporation</p>
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

                            @if (!$isOwner && $bloodRequest->status === 'pending')
                                <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    <a href="tel:{{ $bloodRequest->requester_phone }}"
                                        class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">
                                        Call Requester
                                    </a>

                                    <a href="https://wa.me/{{ $whatsAppPhone }}?text={{ $whatsAppMessage }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex w-full items-center justify-center rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-100">
                                        WhatsApp
                                    </a>
                                </div>
                            @elseif($isOwner)
                                <div class="mt-6 rounded-2xl border border-sky-100 bg-sky-50 px-4 py-3 text-sm text-sky-800">
                                    This is your own request, so contact shortcuts are hidden here.
                                </div>
                            @endif
                        </div>

                        <!-- Status -->
                        <div class="rounded-3xl border border-red-100 bg-gradient-to-br from-red-50 to-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Request Status</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Track the urgency and current state of this blood request.
                            </p>

                            <div class="mt-5 space-y-3 rounded-2xl bg-white/80 p-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-500">Status</span>
                                    <span class="font-semibold text-slate-900">{{ ucfirst($bloodRequest->status) }}</span>
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-500">Emergency</span>
                                    <span class="font-semibold text-slate-900">{{ $bloodRequest->is_emergency ? 'Yes' : 'No' }}</span>
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
                            @if ($isOwner && $bloodRequest->status === 'pending')
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
