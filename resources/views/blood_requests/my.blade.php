@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Requests
            </h2>
            <a href="{{ route('blood-requests.create') }}" class="text-sm underline">
                Create
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Requests List --}}
        @forelse($requests as $r)
            @include('blood_requests._card', ['r' => $r])
        @empty
            <div class="bg-white p-6 rounded shadow-sm">
                No requests yet.
                <a class="underline" href="{{ route('blood-requests.create') }}">
                    Create one
                </a>.
            </div>
        @endforelse

        {{-- Pagination --}}
        {{ $requests->links() }}

    </div>
</div>

@endsection