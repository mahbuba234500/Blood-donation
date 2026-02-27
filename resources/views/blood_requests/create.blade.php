@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200/70 bg-white shadow-sm p-6 sm:p-8">

            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-semibold tracking-tight text-slate-900">
                        Create Blood Request
                    </h2>
                    <p class="mt-1 text-sm text-slate-600">
                        Fill in the details so donors can find and respond quickly.
                    </p>
                </div>

                <div class="hidden sm:flex items-center gap-2">
                    <span class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                        Blood Donation
                    </span>
                </div>
            </div>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
                    <div class="font-semibold">Please fix the following:</div>
                    <ul class="mt-2 list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('blood-requests.store') }}" class="mt-6 space-y-6" id="requestForm">
                @csrf

                {{-- IMPORTANT: tells backend which location mode user selected --}}
                <input type="hidden" name="location_mode" id="location_mode" value="{{ old('location_mode','upazila') }}">

                {{-- Section: requester --}}
                <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-4 sm:p-5">
                    <h3 class="text-sm font-semibold text-slate-900">Requester</h3>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Requester Name</label>
                            <input name="requester_name"
                                   class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                   value="{{ old('requester_name', auth()->user()->name ?? '') }}" required>
                            @error('requester_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Requester Phone</label>
                            <input name="requester_phone"
                                   class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                   value="{{ old('requester_phone', auth()->user()->phone ?? '') }}" required>
                            @error('requester_phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Section: patient + blood --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
                    <h3 class="text-sm font-semibold text-slate-900">Patient & Need</h3>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Patient Name</label>
                        <input name="patient_name"
                               class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                               value="{{ old('patient_name') }}" required>
                        @error('patient_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Blood Group</label>
                            <select name="blood_group"
                                    class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                    required>
                                <option value="">Select</option>
                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                    <option value="{{ $bg }}" @selected(old('blood_group')===$bg)>{{ $bg }}</option>
                                @endforeach
                            </select>
                            @error('blood_group') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-end">
                            <label class="inline-flex items-center gap-2 rounded-2xl border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-800">
                                <input type="checkbox" name="is_emergency" value="1"
                                       class="rounded border-red-300 text-red-600 focus:ring-red-500/40"
                                       @checked(old('is_emergency'))>
                                Emergency
                            </label>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Needed Date</label>
                            <input type="date" name="needed_date"
                                   class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                   value="{{ old('needed_date') }}" required>
                            @error('needed_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Quantity (bags)</label>
                            <input type="number" name="quantity_bags" min="1" max="20"
                                   class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                   value="{{ old('quantity_bags') }}">
                            @error('quantity_bags') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Section: location --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-slate-900">Location</h3>
                        <span class="text-xs text-slate-500">Required for matching donors</span>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Division</label>
                            <select id="division_id" name="division_id"
                                    class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                    required>
                                <option value="">Select</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" @selected(old('division_id')==$division->id)>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('division_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">District</label>
                            <select id="district_id" name="district_id"
                                    class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                    required>
                                <option value="">Select</option>
                            </select>
                            @error('district_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Dhaka toggle --}}
                    <div id="dhakaModeWrapper" class="hidden mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <label class="block text-sm font-semibold text-slate-900">Dhaka Location Type</label>
                        <p class="mt-1 text-xs text-slate-600">Choose how you want to select Dhaka location.</p>

                        <div class="mt-3 flex flex-wrap gap-3">
                            <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700">
                                <input type="radio" name="dhaka_mode_radio" value="upazila" class="text-red-600 focus:ring-red-500/40" checked>
                                <span>Thana/Upazila</span>
                            </label>
                            <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700">
                                <input type="radio" name="dhaka_mode_radio" value="city" class="text-red-600 focus:ring-red-500/40">
                                <span>City Corporation</span>
                            </label>
                        </div>
                    </div>

                    {{-- Upazila --}}
                    <div id="upazilaWrapper" class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Upazila / Thana</label>
                        <select id="upazila_id" name="upazilla_id"
                                class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30">
                            <option value="">Select Upazila</option>
                        </select>
                        @error('upazilla_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- City Corporation --}}
                    <div id="corpWrapper" class="hidden mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">City Corporation</label>
                        <select id="city_corporation_id" name="city_corporation_id"
                                class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30">
                            <option value="">Select City Corporation</option>
                        </select>
                        @error('city_corporation_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- City Area --}}
                    <div id="cityAreaWrapper" class="hidden mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">City Area</label>
                        <select id="city_area_id" name="city_area_id"
                                class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30">
                            <option value="">Select City Area</option>
                        </select>
                        @error('city_area_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Section: extra --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
                    <h3 class="text-sm font-semibold text-slate-900">Additional Details</h3>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Hospital Name (optional)</label>
                            <input name="hospital_name"
                                   class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                   value="{{ old('hospital_name') }}" placeholder="e.g. Dhaka Medical College">
                            @error('hospital_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Address Line (optional)</label>
                            <input name="address_line"
                                   class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                   value="{{ old('address_line') }}" placeholder="Ward/Gate/Road/House etc.">
                            @error('address_line') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Note (optional)</label>
                        <textarea name="note"
                                  class="w-full rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500/30"
                                  rows="3"
                                  placeholder="Anything important...">{{ old('note') }}</textarea>
                        @error('note') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-2">
                    <a href="{{ url()->previous() }}"
                       class="inline-flex justify-center rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>

                    <button id="submitBtn"
                            class="inline-flex justify-center rounded-2xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500/40">
                        Create Request
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
(function () {
    const form = document.getElementById('requestForm');

    const divisionEl = document.getElementById('division_id');
    const districtEl = document.getElementById('district_id');

    const dhakaModeWrapper = document.getElementById('dhakaModeWrapper');

    const upazilaWrapper = document.getElementById('upazilaWrapper');
    const upazilaEl = document.getElementById('upazila_id');

    const corpWrapper = document.getElementById('corpWrapper');
    const corpEl = document.getElementById('city_corporation_id');

    const cityAreaWrapper = document.getElementById('cityAreaWrapper');
    const cityAreaEl = document.getElementById('city_area_id');

    const locationModeEl = document.getElementById('location_mode');

    const submitBtn = document.getElementById('submitBtn');

    const oldDivision = @js(old('division_id'));
    const oldDistrict = @js(old('district_id'));
    const oldUpazila = @js(old('upazilla_id'));
    const oldMode = @js(old('location_mode', 'upazila'));
    const oldCorp = @js(old('city_corporation_id'));
    const oldCityArea = @js(old('city_area_id'));

    function resetSelect(selectEl, placeholder) {
        selectEl.innerHTML = '';
        const opt = document.createElement('option');
        opt.value = '';
        opt.textContent = placeholder;
        selectEl.appendChild(opt);
        selectEl.disabled = false;
    }

    function setLoading(selectEl, text = 'Loading...') {
        selectEl.innerHTML = `<option value="">${text}</option>`;
        selectEl.disabled = true;
    }

    function setVisible(el, visible) {
        el.classList.toggle('hidden', !visible);
    }

    function isDhakaDistrictSelected() {
        const text = districtEl.options[districtEl.selectedIndex]?.textContent?.trim() || '';
        return text.toLowerCase() === 'dhaka';
    }

    async function loadDistricts(divisionId) {
        resetSelect(districtEl, 'Select District');
        resetSelect(upazilaEl, 'Select Upazila');
        resetSelect(corpEl, 'Select City Corporation');
        resetSelect(cityAreaEl, 'Select City Area');

        setVisible(dhakaModeWrapper, false);
        setVisible(upazilaWrapper, true);
        setVisible(corpWrapper, false);
        setVisible(cityAreaWrapper, false);
        locationModeEl.value = 'upazila';

        if (!divisionId) return;

        setLoading(districtEl);

        const res = await fetch(`/locations/divisions/${divisionId}/districts`, {
            headers: { 'Accept': 'application/json' }
        });

        const data = await res.json();

        resetSelect(districtEl, 'Select District');
        data.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d.id;
            opt.textContent = d.name;
            districtEl.appendChild(opt);
        });
    }

    async function loadUpazilas(districtId) {
        resetSelect(upazilaEl, 'Select Upazila');
        if (!districtId) return;

        setLoading(upazilaEl);

        const res = await fetch(`/locations/districts/${districtId}/upazillas`, {
            headers: { 'Accept': 'application/json' }
        });

        const data = await res.json();

        resetSelect(upazilaEl, 'Select Upazila');
        data.forEach(u => {
            const opt = document.createElement('option');
            opt.value = u.id;
            opt.textContent = u.name;
            upazilaEl.appendChild(opt);
        });
    }

    async function loadDhakaCorps() {
        resetSelect(corpEl, 'Select City Corporation');
        resetSelect(cityAreaEl, 'Select City Area');

        const res = await fetch(`/locations/dhaka/city-corporations`, {
            headers: { 'Accept': 'application/json' }
        });

        const corps = await res.json();

        corps.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.name;
            corpEl.appendChild(opt);
        });
    }

    async function loadCityAreas(corpId) {
        resetSelect(cityAreaEl, 'Select City Area');
        if (!corpId) return;

        setLoading(cityAreaEl);

        const res = await fetch(`/locations/dhaka/city-corporations/${corpId}/areas`, {
            headers: { 'Accept': 'application/json' }
        });

        const areas = await res.json();

        resetSelect(cityAreaEl, 'Select City Area');
        areas.forEach(a => {
            const opt = document.createElement('option');
            opt.value = a.id;
            opt.textContent = a.name;
            cityAreaEl.appendChild(opt);
        });
    }

    divisionEl.addEventListener('change', async () => {
        await loadDistricts(divisionEl.value);
    });

    districtEl.addEventListener('change', async () => {
        await loadUpazilas(districtEl.value);

        const isDhaka = isDhakaDistrictSelected();
        setVisible(dhakaModeWrapper, isDhaka);

        if (!isDhaka) {
            locationModeEl.value = 'upazila';
            setVisible(upazilaWrapper, true);
            setVisible(corpWrapper, false);
            setVisible(cityAreaWrapper, false);
            return;
        }

        // default Dhaka -> upazila
        locationModeEl.value = 'upazila';
        document.querySelector('input[name="dhaka_mode_radio"][value="upazila"]').checked = true;
        setVisible(upazilaWrapper, true);
        setVisible(corpWrapper, false);
        setVisible(cityAreaWrapper, false);

        resetSelect(corpEl, 'Select City Corporation');
        resetSelect(cityAreaEl, 'Select City Area');
    });

    document.querySelectorAll('input[name="dhaka_mode_radio"]').forEach(r => {
        r.addEventListener('change', async (e) => {
            const mode = e.target.value;
            locationModeEl.value = mode;

            if (mode === 'city') {
                setVisible(upazilaWrapper, false);
                setVisible(corpWrapper, true);
                setVisible(cityAreaWrapper, true);
                await loadDhakaCorps();
            } else {
                setVisible(upazilaWrapper, true);
                setVisible(corpWrapper, false);
                setVisible(cityAreaWrapper, false);
                resetSelect(corpEl, 'Select City Corporation');
                resetSelect(cityAreaEl, 'Select City Area');
            }
        });
    });

    corpEl.addEventListener('change', async () => {
        await loadCityAreas(corpEl.value);
    });

    // Prevent double submit + keep your debug logs (but safe)
    form.addEventListener('submit', function () {
        console.log('location_mode:', locationModeEl.value);
        console.log('upazilla_id:', upazilaEl.value);
        console.log('city_corporation_id:', corpEl.value);
        console.log('city_area_id:', cityAreaEl.value);

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
            submitBtn.textContent = 'Creating...';
        }
    });

    // INIT restore old()
    (async function init() {
        if (oldDivision) {
            divisionEl.value = oldDivision;
            await loadDistricts(oldDivision);
        } else {
            resetSelect(districtEl, 'Select District');
        }

        if (oldDistrict) {
            districtEl.value = oldDistrict;
            await loadUpazilas(oldDistrict);
        } else {
            resetSelect(upazilaEl, 'Select Upazila');
        }

        const isDhaka = isDhakaDistrictSelected();
        setVisible(dhakaModeWrapper, isDhaka);

        if (isDhaka && oldMode === 'city') {
            locationModeEl.value = 'city';
            document.querySelector('input[name="dhaka_mode_radio"][value="city"]').checked = true;

            setVisible(upazilaWrapper, false);
            setVisible(corpWrapper, true);
            setVisible(cityAreaWrapper, true);

            await loadDhakaCorps();

            if (oldCorp) {
                corpEl.value = oldCorp;
                await loadCityAreas(oldCorp);
            }
            if (oldCityArea) cityAreaEl.value = oldCityArea;
        } else {
            locationModeEl.value = 'upazila';
            if (oldUpazila) upazilaEl.value = oldUpazila;
        }
    })();
})();
</script>
@endsection