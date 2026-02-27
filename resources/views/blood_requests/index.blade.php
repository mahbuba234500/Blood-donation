@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

        {{-- Page Title --}}
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Blood Requests
            </h2>
        </div>

        {{-- Requests List --}}
        @forelse($requests as $r)
            @include('blood_requests._card', ['r' => $r])
        @empty
            <div class="bg-white p-6 rounded shadow-sm">
                No active requests right now.
            </div>
        @endforelse

        {{-- Pagination --}}
        {{ $requests->links() }}

    </div>
</div>

@endsection