@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            <h2 class="text-xl font-semibold mb-4">Create Blood Request</h2>

            <form method="POST" action="{{ route('blood-requests.store') }}" class="space-y-4" id="requestForm">
                @csrf

                {{-- IMPORTANT: tells backend which location mode user selected --}}
                <input type="hidden" name="location_mode" id="location_mode" value="{{ old('location_mode','upazila') }}">

                <div>
                    <label class="block text-sm font-medium mb-1">Requester Name</label>
                    <input name="requester_name" class="w-full border rounded p-2"
                        value="{{ old('requester_name', auth()->user()->name ?? '') }}" required>
                    @error('requester_name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Requester Phone</label>
                    <input name="requester_phone" class="w-full border rounded p-2"
                        value="{{ old('requester_phone', auth()->user()->phone ?? '') }}" required>
                    @error('requester_phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Patient Name</label>
                    <input name="patient_name" class="w-full border rounded p-2"
                        value="{{ old('patient_name') }}" required>
                    @error('patient_name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Blood Group</label>
                    <select name="blood_group" class="w-full border rounded p-2" required>
                        <option value="">Select</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                        <option value="{{ $bg }}" @selected(old('blood_group')===$bg)>{{ $bg }}</option>
                        @endforeach
                    </select>
                    @error('blood_group') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Needed Date</label>
                        <input type="date" name="needed_date" class="w-full border rounded p-2"
                            value="{{ old('needed_date') }}" required>
                        @error('needed_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Quantity (bags)</label>
                        <input type="number" name="quantity_bags" min="1" max="20" class="w-full border rounded p-2"
                            value="{{ old('quantity_bags') }}">
                        @error('quantity_bags') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_emergency" value="1" @checked(old('is_emergency'))>
                    <span class="text-sm">Emergency</span>
                </div>

                <hr class="my-2">

                {{-- Location --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Division</label>
                        <select id="division_id" name="division_id" class="w-full border rounded p-2" required>
                            <option value="">Select</option>
                            @foreach($divisions as $division)
                            <option value="{{ $division->id }}" @selected(old('division_id')==$division->id)>
                                {{ $division->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('division_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">District</label>
                        <select id="district_id" name="district_id" class="w-full border rounded p-2" required>
                            <option value="">Select</option>
                        </select>
                        @error('district_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Dhaka toggle --}}
                <div id="dhakaModeWrapper" class="hidden">
                    <label class="block text-sm font-medium">Dhaka Location Type</label>
                    <div class="mt-2 flex gap-4">
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="dhaka_mode_radio" value="upazila" checked>
                            <span>Thana/Upazila</span>
                        </label>
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="dhaka_mode_radio" value="city">
                            <span>City Corporation</span>
                        </label>
                    </div>
                </div>

                {{-- Upazila --}}
                <div id="upazilaWrapper">
                    <label class="block text-sm font-medium mb-1">Upazila / Thana</label>
                    <select id="upazila_id" name="upazilla_id" class="w-full border rounded p-2">
                        <option value="">Select Upazila</option>
                    </select>
                    @error('upazilla_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- City Corporation --}}
                <div id="corpWrapper" class="hidden">
                    <label class="block text-sm font-medium mb-1">City Corporation</label>
                    <select id="city_corporation_id" name="city_corporation_id" class="w-full border rounded p-2">
                        <option value="">Select City Corporation</option>
                    </select>
                    @error('city_corporation_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- City Area --}}
                <div id="cityAreaWrapper" class="hidden">
                    <label class="block text-sm font-medium mb-1">City Area</label>
                    <select id="city_area_id" name="city_area_id" class="w-full border rounded p-2">
                        <option value="">Select City Area</option>
                    </select>
                    @error('city_area_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Hospital Name (optional)</label>
                        <input name="hospital_name" class="w-full border rounded p-2"
                            value="{{ old('hospital_name') }}" placeholder="e.g. Dhaka Medical College">
                        @error('hospital_name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Address Line (optional)</label>
                        <input name="address_line" class="w-full border rounded p-2"
                            value="{{ old('address_line') }}" placeholder="Ward/Gate/Road/House etc.">
                        @error('address_line') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Note (optional)</label>
                    <textarea name="note" class="w-full border rounded p-2" rows="3"
                        placeholder="Anything important...">{{ old('note') }}</textarea>
                    @error('note') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
                @if ($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Create Request</button>

            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('requestForm').addEventListener('submit', function(e) {

        console.log('location_mode:', locationModeEl.value);
        console.log('upazilla_id:', upazilaEl.value);
        console.log('city_corporation_id:', corpEl.value);
        console.log('city_area_id:', cityAreaEl.value);

        // allow submission after short delay
        setTimeout(() => {
            e.target.submit();
        }, 100);
    });
    (function() {
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
                headers: {
                    'Accept': 'application/json'
                }
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
                headers: {
                    'Accept': 'application/json'
                }
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
                headers: {
                    'Accept': 'application/json'
                }
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
                headers: {
                    'Accept': 'application/json'
                }
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
                if (oldCityArea) {
                    cityAreaEl.value = oldCityArea;
                }
            } else {
                locationModeEl.value = 'upazila';
                if (oldUpazila) upazilaEl.value = oldUpazila;
            }
        })();
    })();
</script>
@endsection