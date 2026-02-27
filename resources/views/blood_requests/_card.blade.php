@php
    $isOwner = auth()->check() && $r->requester_user_id === auth()->id();

    // Build location nicely (avoid trailing commas)
    $parts = [];
    if ($r->cityArea) $parts[] = $r->cityArea->name;
    if ($r->cityCorporation) $parts[] = $r->cityCorporation->name;
    if ($r->upazilla) $parts[] = $r->upazilla->name;
    if ($r->district) $parts[] = $r->district->name;
    if ($r->division) $parts[] = $r->division->name;
@endphp

<div class="rounded-3xl border border-slate-200/70 bg-white p-5 shadow-sm transition hover:shadow-md sm:p-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <!-- Top row: Blood group + badges -->
            <div class="flex flex-wrap items-center gap-2">
                <div class="text-lg font-semibold tracking-tight text-slate-900">
                    {{ $r->blood_group }}
                </div>

                {{-- Bags needed badge --}}
                <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                    {{ (int) $r->quantity_bags }} bag{{ ((int) $r->quantity_bags) === 1 ? '' : 's' }}
                </span>

                @if($r->is_emergency)
                    <span class="inline-flex items-center gap-1 rounded-full border border-red-200 bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                        Emergency
                    </span>
                @endif
            </div>

            <!-- Patient + Needed date -->
            <div class="mt-1 text-sm text-slate-600">
                <span class="font-medium text-slate-700">Patient:</span> {{ $r->patient_name }}
                <span class="mx-1 text-slate-400">•</span>
                <span class="font-medium text-slate-700">Needed:</span> {{ $r->needed_date?->format('d M Y') }}
            </div>

            {{-- Posted X ago --}}
            <div class="mt-1 text-xs text-slate-500">
                Posted {{ $r->created_at?->diffForHumans() }}
            </div>

            <!-- Hospital -->
            @if($r->hospital_name)
                <div class="mt-2 text-sm text-slate-700">
                    <span class="font-medium">Hospital:</span> {{ $r->hospital_name }}
                </div>
            @endif

            <!-- Location -->
            <div class="mt-2 text-sm text-slate-600">
                <span class="font-medium text-slate-700">Location:</span>
                {{ implode(', ', $parts) }}
            </div>

            <!-- Requester -->
            <div class="mt-3 text-sm text-slate-700">
                <span class="font-medium">Requester:</span>
                {{ $r->requester_name }}
                <span class="mx-1 text-slate-400">•</span>
                <span class="font-mono text-slate-800">{{ $r->requester_phone }}</span>
            </div>

            <!-- Address -->
            @if($r->address_line)
                <div class="mt-2 text-sm text-slate-600">
                    <span class="font-medium text-slate-700">Address:</span> {{ $r->address_line }}
                </div>
            @endif

            <!-- Note -->
            @if($r->note)
                <div class="mt-3 rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-700">
                    {{ $r->note }}
                </div>
            @endif
        </div>

        <!-- Right side: status + actions -->
        <div class="shrink-0 text-right">
            <div class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-semibold
                @if($r->status==='pending') border-amber-200 bg-amber-50 text-amber-800
                @elseif($r->status==='cancelled') border-slate-200 bg-slate-50 text-slate-700
                @else border-emerald-200 bg-emerald-50 text-emerald-800
                @endif">
                {{ ucfirst($r->status) }}
            </div>

            @if($isOwner && $r->status === 'pending')
                <div class="mt-3 flex flex-col gap-2">
                    <form method="POST" action="{{ route('blood-requests.complete', $r) }}">
                        @csrf
                        @method('PATCH')
                        <button
                            class="w-full rounded-2xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/40">
                            Mark Completed
                        </button>
                    </form>

                    <form method="POST" action="{{ route('blood-requests.cancel', $r) }}">
                        @csrf
                        @method('PATCH')
                        <button
                            class="w-full rounded-2xl bg-red-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500/40">
                            Cancel
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>