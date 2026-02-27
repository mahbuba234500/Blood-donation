@php
$isOwner = auth()->check() && $r->requester_user_id === auth()->id();
@endphp

<div class="border rounded p-4 bg-white">
    <div class="flex items-start justify-between gap-4">
        <div>
            <div class="font-semibold">
                {{ $r->blood_group }}
                @if($r->is_emergency)
                <span class="ml-2 text-xs px-2 py-1 rounded bg-red-100 text-red-700">Emergency</span>
                @endif
            </div>

            <div class="text-sm text-gray-700 mt-1">
                Patient: {{ $r->patient_name }} • Needed: {{ $r->needed_date?->format('d M Y') }}
            </div>

            <div class="text-sm text-gray-700">
                Hospital: {{ $r->hospital_name }}
            </div>

            <div class="text-sm text-gray-600 mt-1">
                Location:
                @if ($r->cityArea)
                 {{ $r->CityArea->id }} ,
                @endif
                @if($r->cityCorporation),
                {{ $r->cityCorporation->name }} ,
                @endif
                @if($r->upazilla)  {{ $r->upazilla->name }} , @endif

                {{ $r->district?->name }},
                {{ $r->division?->name }},



            </div>

            <div class="text-sm mt-2">
                <span class="font-medium">Requester:</span> {{ $r->requester_name }} • {{ $r->requester_phone }}
            </div>

            @if($r->hospital_name)
            <div class="text-sm text-gray-700">Hospital: {{ $r->hospital_name }}</div>
            @endif

            @if($r->address_line)
            <div class="text-sm text-gray-600 mt-1">Address: {{ $r->address_line }}</div>
            @endif

            @if($r->note)
            <div class="text-sm text-gray-600 mt-2">{{ $r->note }}</div>
            @endif
        </div>

        <div class="text-right">
            <div class="text-xs px-2 py-1 rounded inline-block
                @if($r->status==='pending') bg-yellow-100 text-yellow-800
                @elseif($r->status==='cancelled') bg-gray-100 text-gray-700
                @else bg-green-100 text-green-800
                @endif">
                {{ ucfirst($r->status) }}
            </div>

            @if($isOwner)
            <div class="mt-3 flex flex-col gap-2">
                @if($r->status === 'pending')
                <form method="POST" action="{{ route('blood-requests.complete', $r) }}">
                    @csrf @method('PATCH')
                    <button class="w-full text-xs px-3 py-2 rounded bg-green-600 text-white">
                        Mark Completed
                    </button>
                </form>

                <form method="POST" action="{{ route('blood-requests.cancel', $r) }}">
                    @csrf @method('PATCH')
                    <button class="w-full text-xs px-3 py-2 rounded bg-red-600 text-white">
                        Cancel
                    </button>
                </form>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>