@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                    My Requests
                </h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Manage and track your blood requests.
                </p>
            </div>

            <a href="{{ route('blood-requests.create') }}"
               class="inline-flex items-center justify-center rounded-2xl px-4 py-2 text-sm font-semibold
                      bg-red-600 text-white shadow-sm hover:bg-red-700
                      focus:outline-none focus:ring-2 focus:ring-red-500/60 focus:ring-offset-2
                      focus:ring-offset-slate-50 dark:focus:ring-offset-slate-950">
                Create Request
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800
                        dark:border-emerald-900/40 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Requests List --}}
        <div class="space-y-4">
            @forelse($requests as $r)
                @include('blood_requests._card', ['r' => $r])
            @empty
                <div class="rounded-3xl border border-slate-200/70 bg-white/70 p-8 text-center shadow-sm backdrop-blur
                            dark:border-slate-800 dark:bg-slate-900/60">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-red-500/10 text-red-600 dark:text-red-400">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2s7 7 7 12a7 7 0 0 1-14 0c0-5 7-12 7-12z"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">
                        No requests yet
                    </h3>

                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                        Create your first blood request to get started.
                    </p>

                    <div class="mt-5">
                        <a href="{{ route('blood-requests.create') }}"
                           class="inline-flex items-center justify-center rounded-2xl px-4 py-2 text-sm font-semibold
                                  bg-red-600 text-white shadow-sm hover:bg-red-700
                                  focus:outline-none focus:ring-2 focus:ring-red-500/60 focus:ring-offset-2
                                  focus:ring-offset-slate-50 dark:focus:ring-offset-slate-950">
                            Create Request
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($requests->hasPages())
            <div class="pt-2">
                <div class="rounded-3xl border border-slate-200/70 bg-white/70 px-4 py-3 shadow-sm backdrop-blur
                            dark:border-slate-800 dark:bg-slate-900/60">
                    {{ $requests->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection