@extends('layouts.app')

@section('content')
    <div class="relative py-10">

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl border border-slate-200/70 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800">

                <!-- Header -->
                <div class="flex items-center justify-between border-b border-slate-200/70 px-6 py-5 dark:border-slate-800">

                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">
                        Notifications
                    </h1>

                    @if(auth()->user()->unreadNotifications->count())
                        <form method="POST" action="{{ route('notifications.readAll') }}">
                            @csrf
                            <button class="text-sm font-medium text-red-600 hover:text-red-700">
                                Mark all as read
                            </button>
                        </form>
                    @endif

                </div>

                <!-- Notifications -->
                <div class="p-6 space-y-4">

                    @forelse($notifications as $notification)

                        @php
                            $data = $notification->data;
                        @endphp

                        <div
                            class="rounded-2xl border p-4
                            {{ $notification->read_at ? 'border-slate-200 dark:border-slate-800' : 'border-red-200 bg-red-50 dark:border-red-900 dark:bg-red-950/30' }}">

                            <div class="flex items-start justify-between gap-4">

                                <div>

                                    <p class="font-medium text-slate-900 dark:text-slate-100">
                                        {{ $data['message'] ?? 'New notification' }}
                                    </p>

                                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
                                        Blood Group:
                                        <span class="font-semibold text-red-600">
                                            {{ $data['blood_group'] ?? '-' }}
                                        </span>
                                    </p>

                                    <p class="text-sm text-slate-600 dark:text-slate-300">
                                        Patient:
                                        {{ $data['patient_name'] ?? '-' }}
                                    </p>

                                    <p class="text-sm text-slate-600 dark:text-slate-300">
                                        Contact:
                                        {{ $data['requester_phone'] ?? '-' }}
                                    </p>

                                    <p class="mt-2 text-xs text-slate-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>

                                </div>

                                @if(!$notification->read_at)
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf
                                        <button
                                            class="rounded-xl bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
                                            Mark read
                                        </button>
                                    </form>
                                @endif

                            </div>

                        </div>

                    @empty

                        <div
                            class="rounded-2xl border border-dashed border-slate-300 p-10 text-center text-slate-500 dark:border-slate-700">
                            No notifications yet
                        </div>

                    @endforelse

                </div>

                <div class="px-6 pb-6">
                    {{ $notifications->links() }}
                </div>

            </div>

        </div>

    </div>
@endsection
