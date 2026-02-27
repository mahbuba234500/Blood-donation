<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Complete Your Profile
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6"
                 x-data="profileForm()">

                <form method="POST" action="{{ route('profile.complete.store') }}" class="space-y-4">
                    @csrf

                    <!-- Phone -->
                    <div>
                        <x-input-label for="phone" value="Phone" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                      value="{{ old('phone', $user->phone) }}" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Blood Group -->
                    <div>
                        <x-input-label for="blood_group" value="Blood Group" />
                        <select id="blood_group" name="blood_group" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">Select</option>
                            @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                                <option value="{{ $bg }}" @selected(old('blood_group', $user->blood_group) === $bg)>{{ $bg }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('blood_group')" class="mt-2" />
                    </div>

                    <!-- Division -->
                    <div>
                        <x-input-label for="division_id" value="Division" />
                        <select id="division_id" name="division_id" class="mt-1 block w-full border-gray-300 rounded-md"
                                x-model="divisionId" @change="loadDistricts()" required>
                            <option value="">Select Division</option>
                            @foreach($divisions as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('division_id')" class="mt-2" />
                    </div>

                    <!-- District -->
                    <div>
                        <x-input-label for="district_id" value="District/City" />
                        <select id="district_id" name="district_id" class="mt-1 block w-full border-gray-300 rounded-md"
                                x-model="districtId" @change="loadAreas()" :disabled="districts.length===0" required>
                            <option value="">Select District</option>
                            <template x-for="dist in districts" :key="dist.id">
                                <option :value="dist.id" x-text="dist.name"></option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('district_id')" class="mt-2" />
                    </div>

                    <!-- Area -->
                    <div>
                        <x-input-label for="area_id" value="Area" />
                        <select id="area_id" name="area_id" class="mt-1 block w-full border-gray-300 rounded-md"
                                x-model="areaId" :disabled="areas.length===0" required>
                            <option value="">Select Area</option>
                            <template x-for="a in areas" :key="a.id">
                                <option :value="a.id" x-text="a.name"></option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('area_id')" class="mt-2" />
                    </div>

                    <!-- Address Line -->
                    <div>
                        <x-input-label for="address_line" value="Address Line (Optional)" />
                        <x-text-input id="address_line" name="address_line" type="text" class="mt-1 block w-full"
                                      value="{{ old('address_line', $user->address_line) }}" />
                        <x-input-error :messages="$errors->get('address_line')" class="mt-2" />
                    </div>

                    <!-- Medical History -->
                    <div>
                        <x-input-label for="medical_history" value="Medical History (Optional)" />
                        <textarea id="medical_history" name="medical_history"
                                  class="mt-1 block w-full border-gray-300 rounded-md"
                                  rows="4">{{ old('medical_history', $user->medical_history) }}</textarea>
                        <x-input-error :messages="$errors->get('medical_history')" class="mt-2" />
                    </div>

                    <!-- Become Donor Toggle -->
                    <div class="border rounded-md p-4">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="become_donor" value="1" x-model="becomeDonor">
                            <span class="font-medium">I want to become a donor</span>
                        </label>

                        <div class="mt-3" x-show="becomeDonor" x-cloak>
                            <x-input-label for="last_donate_date" value="Last Donate Date (Optional)" />
                            <x-text-input id="last_donate_date" name="last_donate_date" type="date" class="mt-1 block w-full"
                                          value="{{ old('last_donate_date') }}" />
                            <p class="text-sm text-gray-500 mt-1">
                                If you donated recently, the system can hide you until eligible.
                            </p>
                            <x-input-error :messages="$errors->get('last_donate_date')" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-2">
                        <x-primary-button>Save Profile</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function profileForm() {
            return {
                divisionId: "{{ old('division_id', $user->division_id) }}",
                districtId: "{{ old('district_id', $user->district_id) }}",
                areaId: "{{ old('area_id', $user->area_id) }}",
                districts: [],
                areas: [],
                becomeDonor: false,

                async loadDistricts() {
                    this.districts = [];
                    this.areas = [];
                    this.districtId = "";
                    this.areaId = "";

                    if (!this.divisionId) return;

                    const res = await fetch(`/locations/divisions/${this.divisionId}/districts`);
                    this.districts = await res.json();
                },

                async loadAreas() {
                    this.areas = [];
                    this.areaId = "";

                    if (!this.districtId) return;

                    const res = await fetch(`/locations/districts/${this.districtId}/areas`);
                    this.areas = await res.json();
                },

                async init() {
                    // If editing existing user (rare at completion stage), preload cascading selections
                    if (this.divisionId) {
                        await this.loadDistricts();
                        if (this.districtId) {
                            await this.loadAreas();
                        }
                    }
                }
            }
        }
        document.addEventListener('alpine:init', () => {});
    </script>
</x-app-layout>
