@csrf

<div class="grid gap-5 md:grid-cols-2 mb-6">
    <!-- Client -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5" for="client_id">Client <span
                class="text-red-500">*</span></label>
        <div class="relative">
            <select id="client_id" name="client_id"
                class="block w-full pl-4 pr-10 py-2.5 border border-[rgba(38,166,154,0.25)] rounded-xl bg-white focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] sm:text-sm text-slate-700 appearance-none font-medium transition-colors cursor-pointer"
                required>
                <option value="" disabled selected>Select a client</option>
                @foreach ($clients as $clientOption)
                    <option value="{{ $clientOption->id }}" @selected(old('client_id', $appointment->client_id ?? '') == $clientOption->id)>{{ $clientOption->full_name }}</option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Staff -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5" for="staff_id">Assign to Staff <span
                class="text-red-500">*</span></label>
        <div class="relative">
            <select id="staff_id" name="staff_id"
                class="block w-full pl-4 pr-10 py-2.5 border border-[rgba(38,166,154,0.25)] rounded-xl bg-white focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] sm:text-sm text-slate-700 appearance-none font-medium transition-colors cursor-pointer"
                required>
                <option value="" disabled selected>Select staff member</option>
                @foreach ($staffMembers as $staff)
                    <option value="{{ $staff->id }}" @selected(old('staff_id', $appointment->staff_id ?? '') == $staff->id)>
                        Dr. {{ $staff->name }}</option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Service Type -->
    <div class="md:col-span-2">
        <label class="block text-xs font-bold text-slate-700 mb-1.5" for="service_type">Service Type <span
                class="text-red-500">*</span></label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-[#26a69a]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <path d="m9 11 3 3L22 4" />
                </svg>
            </div>
            <select id="service_type" name="service_type"
                class="block w-full pl-10 pr-10 py-2.5 border border-[rgba(38,166,154,0.25)] rounded-xl bg-white focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] sm:text-sm text-slate-800 appearance-none font-bold transition-colors cursor-pointer"
                required>
                <option value="Grooming" @selected(old('service_type', $appointment->service_type ?? '') == 'Grooming')>
                    Grooming</option>
                <option value="Vaccination" @selected(old('service_type', $appointment->service_type ?? '') == 'Vaccination')>Vaccination</option>
                <option value="Checkups" @selected(old('service_type', $appointment->service_type ?? '') == 'Checkups')>
                    Checkups</option>
                <option value="Dental" @selected(old('service_type', $appointment->service_type ?? '') == 'Dental')>Dental
                </option>
                <option value="Surgery" @selected(old('service_type', $appointment->service_type ?? '') == 'Surgery')>
                    Surgery</option>
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Date, Time, Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:col-span-2">
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5" for="appointment_date">Date <span
                    class="text-red-500">*</span></label>
            <input id="appointment_date" type="date" name="appointment_date"
                value="{{ old('appointment_date', isset($appointment) ? $appointment->appointment_date?->format('Y-m-d') : '') }}"
                class="block w-full px-4 py-2.5 border border-[rgba(38,166,154,0.25)] rounded-xl bg-white focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] sm:text-sm text-slate-700 font-medium transition-colors"
                required>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5" for="appointment_time">Time <span
                    class="text-red-500">*</span></label>
            <input id="appointment_time" type="time" name="appointment_time"
                value="{{ old('appointment_time', isset($appointment) ? $appointment->formatted_time : '') }}"
                class="block w-full px-4 py-2.5 border border-[rgba(38,166,154,0.25)] rounded-xl bg-white focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] sm:text-sm text-slate-700 font-medium transition-colors"
                required>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5" for="status">Status</label>
            <div class="relative">
                <select id="status" name="status"
                    class="block w-full pl-4 pr-10 py-2.5 border border-[rgba(38,166,154,0.25)] rounded-xl bg-white focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] sm:text-sm text-slate-700 appearance-none font-medium transition-colors cursor-pointer">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(old('status', $appointment->status ?? 'Scheduled') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    <div class="md:col-span-2">
        <label class="block text-xs font-bold text-slate-700 mb-1.5" for="notes">Notes</label>
        <textarea id="notes" name="notes" rows="3"
            class="block w-full px-4 py-3 border border-[rgba(38,166,154,0.25)] rounded-xl bg-white focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] sm:text-sm text-slate-700 font-medium transition-colors placeholder-slate-400"
            placeholder="Additional notes, special instructions, or concerns...">{{ old('notes', $appointment->notes ?? '') }}</textarea>
    </div>
</div>

<div
    class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-2 border-t border-[rgba(38,166,154,0.2)]">
    <a href="{{ route('appointments.index') }}"
        class="w-full sm:w-auto px-6 py-2.5 bg-white border border-[rgba(38,166,154,0.25)] text-slate-600 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors text-center">
        Cancel
    </a>
    <button type="submit"
        class="w-full sm:w-auto px-6 py-2.5 bg-[#26a69a] text-white font-bold rounded-xl text-sm hover:bg-[#1f8c82] transition-colors flex items-center justify-center gap-2 shadow-sm">
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5">
            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
            <line x1="16" x2="16" y1="2" y2="6" />
            <line x1="8" x2="8" y1="2" y2="6" />
            <line x1="3" x2="21" y1="10" y2="10" />
        </svg>
        {{ isset($appointment) && $appointment->exists ? 'Update Appointment' : 'Schedule Appointment' }}
    </button>
</div>