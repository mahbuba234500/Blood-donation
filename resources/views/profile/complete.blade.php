@extends('layouts.app')

@section('content')
<div class="relative">
    <!-- Soft background glow -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-red-500/10 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-red-500/10 blur-3xl"></div>
    </div>

    <div class="relative py-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-slate-200/70 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800">
                <div class="p-6 sm:p-8">
                    <div class="flex items-start justify-between gap-6">
                        <div>
                            <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                                Complete Your Profile
                            </h1>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                                Add your contact & location to help match donors faster.
                            </p>
                        </div>

                        <div class="hidden sm:flex items-center gap-2 rounded-2xl border border-red-200/60 bg-red-50 px-3 py-2 text-sm text-red-700 dark:border-red-900/40 dark:bg-red-950/40 dark:text-red-200">
                            <span class="inline-flex h-2 w-2 rounded-full bg-red-500"></span>
                            Blood Donation Profile
                        </div>
                    </div>

                    @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-900/40 dark:bg-red-950/40 dark:text-red-200">
                        <p class="font-medium mb-2">Please fix the following:</p>
                        <ul class="list-disc pl-5 space-y-1 text-sm">
                            @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.complete.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <input type="hidden" name="location_mode" id="location_mode" value="{{ old('location_mode','upazila') }}">

                        <!-- Section: Basics -->
                        <div class="rounded-2xl border border-slate-200/70 p-5 dark:border-slate-800">
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Basic Info</h2>

                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Phone</label>
                                    <input name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                                  focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                                  dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                                        placeholder="01XXXXXXXXX" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Blood Group</label>
                                    <select name="blood_group"
                                        class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                                   focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                                   dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" required>
                                        <option value="">Select Blood Group</option>
                                        @php
                                        $groups=['A+','A-','B+','B-','O+','O-','AB+','AB-'];
                                        $sel=old('blood_group',$user->blood_group);
                                        @endphp
                                        @foreach($groups as $g)
                                        <option value="{{ $g }}" @selected($sel===$g)>{{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Location -->
                        <div class="rounded-2xl border border-slate-200/70 p-5 dark:border-slate-800">
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Location</h2>

                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Division</label>
                                    <select id="division" name="division_id"
                                        class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                                   focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                                   dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" required>
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $d)
                                        <option value="{{ $d->id }}" @selected(old('division_id')==$d->id)>{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">District</label>
                                    <select id="district" name="district_id"
                                        class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                                   focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                                   dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" required>
                                        <option value="">Select District</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Dhaka toggle --}}
                            <div id="dhakaModeWrapper" class="hidden mt-5">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Dhaka Location Type</label>
                                <div class="mt-2 flex flex-wrap gap-3">
                                    <label class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm dark:border-slate-800">
                                        <input type="radio" name="dhaka_mode_radio" value="upazila" checked class="text-red-600 focus:ring-red-500">
                                        <span>Thana/Upazila</span>
                                    </label>
                                    <label class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm dark:border-slate-800">
                                        <input type="radio" name="dhaka_mode_radio" value="city" class="text-red-600 focus:ring-red-500">
                                        <span>City Corporation</span>
                                    </label>
                                </div>
                            </div>

                            <div id="upazilaWrapper" class="mt-5">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Upazila / Thana</label>
                                <select id="upazila" name="upazilla_id"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                               focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                               dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                                    <option value="">Select Upazila</option>
                                </select>
                                @error('upazilla_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div id="corpWrapper" class="hidden mt-5">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">City Corporation</label>
                                <select id="city_corporation" name="city_corporation_id"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                               focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                               dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                                    <option value="">Select City Corporation</option>
                                </select>
                            </div>

                            <div id="cityAreaWrapper" class="hidden mt-5">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">City Area</label>
                                <select id="city_area" name="city_area_id"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                               focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                               dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                                    <option value="">Select City Area</option>
                                </select>
                            </div>
                        </div>

                        <!-- Section: Optional -->
                        <div class="rounded-2xl border border-slate-200/70 p-5 dark:border-slate-800">
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Optional Details</h2>

                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Address (Optional)</label>
                                    <input name="address_line" value="{{ old('address_line', $user->address_line) }}"
                                        class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                                  focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                                  dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                                        placeholder="House/road, etc.">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Medical History (Optional)</label>
                                    <textarea name="medical_history" rows="3"
                                        class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                                     focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                                     dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">{{ old('medical_history', $user->medical_history) }}</textarea>
                                </div>

                                <div class="rounded-2xl border border-slate-200/70 p-4 dark:border-slate-800">
                                    <label class="inline-flex items-center gap-2">
                                        <input type="checkbox" id="become_donor" name="become_donor" value="1"
                                            class="rounded border-slate-300 text-red-600 focus:ring-red-500 dark:border-slate-700"
                                            @checked(old('become_donor'))>
                                        <span class="font-medium text-slate-800 dark:text-slate-100">I want to be a donor</span>
                                    </label>

                                    <div id="donorDateWrapper" class="hidden mt-3">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Last Donation Date</label>
                                        <input type="date" name="last_donate_date" value="{{ old('last_donate_date') }}"
                                            class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none
                                                      focus:border-red-500 focus:ring-2 focus:ring-red-500/20
                                                      dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex justify-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm
                                      hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                                Cancel
                            </a>

                            <button type="submit"
                                class="inline-flex justify-center rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm
                                           hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
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

        divisionEl?.addEventListener('change', () => loadDistricts(divisionEl.value));

        districtEl?.addEventListener('change', async () => {
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

        corpEl?.addEventListener('change', () => loadCityAreas(corpEl.value));

        function toggleDonorDate() {
            setVisible(donorDateWrapper, becomeDonorEl.checked);
        }
        becomeDonorEl?.addEventListener('change', toggleDonorDate);
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
@endsection