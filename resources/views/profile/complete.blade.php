<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Complete Your Profile</h1>

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-red-800">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.complete.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="location_mode" id="location_mode" value="{{ old('location_mode','upazila') }}">

            <div>
                <label class="block text-sm font-medium">Phone</label>
                <input name="phone" value="{{ old('phone', $user->phone) }}"
                       class="mt-1 w-full border rounded p-2" placeholder="01XXXXXXXXX" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Blood Group</label>
                <select name="blood_group" class="mt-1 w-full border rounded p-2" required>
                    <option value="">Select Blood Group</option>
                    @php $groups=['A+','A-','B+','B-','O+','O-','AB+','AB-']; $sel=old('blood_group',$user->blood_group); @endphp
                    @foreach($groups as $g)
                        <option value="{{ $g }}" @selected($sel===$g)>{{ $g }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Division</label>
                <select id="division" name="division_id" class="mt-1 w-full border rounded p-2" required>
                    <option value="">Select Division</option>
                    @foreach($divisions as $d)
                        <option value="{{ $d->id }}" @selected(old('division_id')==$d->id)>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">District</label>
                <select id="district" name="district_id" class="mt-1 w-full border rounded p-2" required>
                    <option value="">Select District</option>
                </select>
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

            <div id="upazilaWrapper">
                <label class="block text-sm font-medium">Upazila / Thana</label>
                <select id="upazila" name="upazilla_id" class="mt-1 w-full border rounded p-2">
                    <option value="">Select Upazila</option>
                </select>
                @error('upazilla_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="corpWrapper" class="hidden">
                <label class="block text-sm font-medium">City Corporation</label>
                <select id="city_corporation" name="city_corporation_id" class="mt-1 w-full border rounded p-2">
                    <option value="">Select City Corporation</option>
                </select>
            </div>

            <div id="cityAreaWrapper" class="hidden">
                <label class="block text-sm font-medium">City Area</label>
                <select id="city_area" name="city_area_id" class="mt-1 w-full border rounded p-2">
                    <option value="">Select City Area</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Address (Optional)</label>
                <input name="address_line" value="{{ old('address_line', $user->address_line) }}"
                       class="mt-1 w-full border rounded p-2" placeholder="House/road, etc.">
            </div>

            <div>
                <label class="block text-sm font-medium">Medical History (Optional)</label>
                <textarea name="medical_history" class="mt-1 w-full border rounded p-2" rows="3">{{ old('medical_history', $user->medical_history) }}</textarea>
            </div>

            <div class="border rounded p-4">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" id="become_donor" name="become_donor" value="1" @checked(old('become_donor'))>
                    <span class="font-medium">I want to be a donor</span>
                </label>

                <div id="donorDateWrapper" class="hidden mt-3">
                    <label class="block text-sm font-medium">Last Donation Date</label>
                    <input type="date" name="last_donate_date" value="{{ old('last_donate_date') }}"
                           class="mt-1 w-full border rounded p-2">
                </div>
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save Profile</button>
        </form>
    </div>
</div>

<script>
(function () {
    const divisionEl = document.getElementById('division');
    const districtEl = document.getElementById('district');
    const upazilaEl = document.getElementById('upazila');

    const dhakaModeWrapper = document.getElementById('dhakaModeWrapper');
    const upazilaWrapper = document.getElementById('upazilaWrapper');

    const corpWrapper = document.getElementById('corpWrapper');
    const corpEl = document.getElementById('city_corporation');

    const cityAreaWrapper = document.getElementById('cityAreaWrapper');
    const cityAreaEl = document.getElementById('city_area');

    const locationModeEl = document.getElementById('location_mode');

    const becomeDonorEl = document.getElementById('become_donor');
    const donorDateWrapper = document.getElementById('donorDateWrapper');

    function resetSelect(selectEl, placeholder) {
        selectEl.innerHTML = '';
        const opt = document.createElement('option');
        opt.value = '';
        opt.textContent = placeholder;
        selectEl.appendChild(opt);
    }

    function setVisible(el, visible) {
        el.classList.toggle('hidden', !visible);
    }

    async function loadDistricts(divisionId) {
        resetSelect(districtEl, 'Select District');
        resetSelect(upazilaEl, 'Select Upazila');

        setVisible(dhakaModeWrapper, false);
        setVisible(corpWrapper, false);
        setVisible(cityAreaWrapper, false);
        setVisible(upazilaWrapper, true);
        locationModeEl.value = 'upazila';

        if (!divisionId) return;

        const res = await fetch(`/locations/divisions/${divisionId}/districts`);
        const data = await res.json();
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

        const res = await fetch(`/locations/districts/${districtId}/upazillas`);
        const data = await res.json();
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

        const res = await fetch(`/locations/dhaka/city-corporations`);
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

        const res = await fetch(`/locations/dhaka/city-corporations/${corpId}/areas`);
        const areas = await res.json();

        areas.forEach(a => {
            const opt = document.createElement('option');
            opt.value = a.id;
            opt.textContent = a.name;
            cityAreaEl.appendChild(opt);
        });
    }

    function isDhakaDistrictSelected() {
        const text = districtEl.options[districtEl.selectedIndex]?.textContent?.trim();
        return text === 'Dhaka';
    }

    divisionEl.addEventListener('change', () => loadDistricts(divisionEl.value));

    districtEl.addEventListener('change', async () => {
        await loadUpazilas(districtEl.value);

        const isDhaka = isDhakaDistrictSelected();
        setVisible(dhakaModeWrapper, isDhaka);

        if (!isDhaka) {
            setVisible(upazilaWrapper, true);
            setVisible(corpWrapper, false);
            setVisible(cityAreaWrapper, false);
            locationModeEl.value = 'upazila';
            return;
        }

        // default upazila mode when Dhaka
        locationModeEl.value = 'upazila';
        document.querySelector('input[name="dhaka_mode_radio"][value="upazila"]').checked = true;
        setVisible(upazilaWrapper, true);
        setVisible(corpWrapper, false);
        setVisible(cityAreaWrapper, false);
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

    corpEl.addEventListener('change', () => loadCityAreas(corpEl.value));

    function toggleDonorDate() {
        setVisible(donorDateWrapper, becomeDonorEl.checked);
    }
    becomeDonorEl.addEventListener('change', toggleDonorDate);
    toggleDonorDate();

    // restore old values
    const oldDivision = "{{ old('division_id') }}";
    const oldDistrict = "{{ old('district_id') }}";
    const oldUpazila = "{{ old('upazilla_id') }}";
    const oldMode = "{{ old('location_mode','upazila') }}";
    const oldCorp = "{{ old('city_corporation_id') }}";
    const oldCityArea = "{{ old('city_area_id') }}";

    (async function init() {
        if (oldDivision) {
            divisionEl.value = oldDivision;
            await loadDistricts(oldDivision);
        }
        if (oldDistrict) {
            districtEl.value = oldDistrict;
            await loadUpazilas(oldDistrict);
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
            if (oldUpazila) upazilaEl.value = oldUpazila;
        }
    })();
})();
</script>

</body>
</html>
