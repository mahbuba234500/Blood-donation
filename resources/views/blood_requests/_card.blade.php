@php
    $isOwner = auth()->check() && $r->requester_user_id === auth()->id();

    $parts = [];
    if ($r->cityArea) $parts[] = $r->cityArea->name;
    if ($r->cityCorporation) $parts[] = $r->cityCorporation->name;
    if ($r->upazilla) $parts[] = $r->upazilla->name;
    if ($r->district) $parts[] = $r->district->name;
    if ($r->division) $parts[] = $r->division->name;

    $statusClasses = match ($r->status) {
        'pending' => 'border-amber-200 bg-amber-50 text-amber-800',
        'cancelled' => 'border-slate-200 bg-slate-100 text-slate-700',
        'completed' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
        default => 'border-slate-200 bg-slate-100 text-slate-700',
    };
@endphp

<div class="overflow-hidden rounded-[30px] border border-white/80 bg-white/90 p-5 shadow-[0_10px_35px_rgba(15,23,42,0.06)] backdrop-blur transition hover:-translate-y-0.5 hover:shadow-[0_18px_45px_rgba(15,23,42,0.08)] sm:p-6">
    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
        <!-- Left content -->
        <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-center gap-2.5">
                <div class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-sm font-bold text-red-700 ring-1 ring-red-100">
                    {{ $r->blood_group }}
                </div>

                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                    {{ (int) $r->quantity_bags }} bag{{ ((int) $r->quantity_bags) === 1 ? '' : 's' }}
                </span>

                @if($r->is_emergency)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 ring-1 ring-red-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                        Emergency
                    </span>
                @endif

                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusClasses }}">
                    {{ ucfirst($r->status) }}
                </span>
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-slate-600">
                <span class="font-medium text-slate-800">Patient:</span>
                <span>{{ $r->patient_name }}</span>

                <span class="text-slate-300">•</span>

                <span class="font-medium text-slate-800">Needed:</span>
                <span>{{ $r->needed_date?->format('d M Y') }}</span>
            </div>

            <div class="mt-1 text-xs text-slate-500">
                Posted {{ $r->created_at?->diffForHumans() }}
            </div>

            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                @if($r->hospital_name)
                    <div class="rounded-2xl border border-rose-100 bg-rose-50/50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Hospital
                        </div>
                        <div class="mt-1 text-sm font-medium text-slate-800">
                            {{ $r->hospital_name }}
                        </div>
                    </div>
                @endif

                <div class="rounded-2xl border border-slate-100 bg-white p-4">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Location
                    </div>
                    <div class="mt-1 text-sm font-medium text-slate-800">
                        {{ implode(', ', $parts) ?: 'Location not specified' }}
                    </div>
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-slate-100 bg-slate-50/70 p-4">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Requester
                </div>
                <div class="mt-1 text-sm text-slate-700">
                    <span class="font-medium text-slate-800">{{ $r->requester_name }}</span>
                    <span class="mx-2 text-slate-300">•</span>
                    <span class="font-mono text-slate-700">{{ $r->requester_phone }}</span>
                </div>
            </div>

            @if($r->address_line)
                <div class="mt-4 rounded-2xl border border-slate-100 bg-white p-4">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Address
                    </div>
                    <div class="mt-1 text-sm leading-6 text-slate-700">
                        {{ $r->address_line }}
                    </div>
                </div>
            @endif

            @if($r->note)
                <div class="mt-4 rounded-2xl border border-amber-100 bg-amber-50/70 p-4">
                    <div class="text-xs font-semibold uppercase tracking-wide text-amber-700">
                        Note
                    </div>
                    <div class="mt-1 text-sm leading-6 text-slate-700">
                        {{ $r->note }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Right actions -->
        @if($isOwner && $r->status === 'pending')
            <div class="w-full shrink-0 lg:w-44">
                <div class="rounded-[26px] border border-rose-100 bg-rose-50/50 p-3">
                    <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Actions
                    </div>

                    <div class="space-y-2">
                        <form method="POST" action="{{ route('blood-requests.complete', $r) }}">
                            @csrf
                            @method('PATCH')
                            <button
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                Mark Completed
                            </button>
                        </form>

                        <form method="POST" action="{{ route('blood-requests.cancel', $r) }}">
                            @csrf
                            @method('PATCH')
                            <button
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200">
                                Cancel Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>