@extends('layouts.app')
@section('title', $client->full_name)
@section('content')

{{-- Background: clients list (blurred) --}}
<div class="fixed inset-0 z-40 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

    {{-- View Modal --}}
    <div id="viewModal" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

        {{-- Header --}}
        <div class="flex items-center gap-3 p-6 pb-4">
            <div class="w-11 h-11 rounded-xl bg-[#E8F5F3] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-sm font-bold text-slate-800">{{ $client->full_name }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">Client ID: cli-{{ $client->id }}</p>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->isAdmin() || auth()->user()->isReceptionist())
                <button onclick="document.getElementById('viewModal').classList.add('hidden');document.getElementById('editModal').classList.remove('hidden')"
                    class="px-3 py-1.5 text-xs font-bold text-slate-600 border border-[rgba(38,166,154,0.25)] rounded-xl hover:bg-slate-50 transition-colors">
                    Edit
                </button>
                @endif
                <a href="{{ route('clients.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors ml-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="px-6 pb-6 space-y-4">

            {{-- Two-column: Contact + Pet/Notes --}}
            <div class="grid md:grid-cols-2 gap-4">

                {{-- Contact Information --}}
                <div class="bg-slate-50 rounded-2xl p-4 border border-[rgba(38,166,154,0.2)]">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <h3 class="text-sm font-bold text-slate-700">Contact Information</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Email</p>
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <p class="text-sm font-semibold text-slate-800">{{ $client->email ?: '—' }}</p>
                            </div>
                        </div>
                        <div class="border-t border-[rgba(38,166,154,0.25)] pt-3">
                            <p class="text-xs text-slate-400 mb-0.5">Phone</p>
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <p class="text-sm font-semibold text-slate-800">{{ $client->phone ?: '—' }}</p>
                            </div>
                        </div>
                        <div class="border-t border-[rgba(38,166,154,0.25)] pt-3">
                            <p class="text-xs text-slate-400 mb-0.5">Address</p>
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <p class="text-sm font-semibold text-slate-800">{{ $client->address ?: '—' }}</p>
                            </div>
                        </div>
                        <div class="border-t border-[rgba(38,166,154,0.25)] pt-3">
                            <p class="text-xs text-slate-400 mb-0.5">Client Since</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $client->created_at->format('Y-m-d') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Pet Information --}}
                <div class="bg-slate-50 rounded-2xl p-4 border border-[rgba(38,166,154,0.2)]">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <h3 class="text-sm font-bold text-slate-700">Pet Information</h3>
                    </div>
                    @if($client->pet_name || $client->pet_species || $client->pet_breed)
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Pet Name</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $client->pet_name ?: '—' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 border-t border-[rgba(38,166,154,0.25)] pt-3">
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Species</p>
                                <p class="text-sm font-semibold text-slate-800">{{ $client->pet_species ?: '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Breed</p>
                                <p class="text-sm font-semibold text-slate-800">{{ $client->pet_breed ?: '—' }}</p>
                            </div>
                        </div>
                        @if($client->notes)
                        <div class="border-t border-[rgba(38,166,154,0.25)] pt-3">
                            <p class="text-xs text-slate-400 mb-1">Notes</p>
                            <div class="bg-white rounded-xl p-3 border border-[rgba(38,166,154,0.2)]">
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $client->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <p class="text-xs text-slate-400 italic">No pet information recorded.</p>
                    @if($client->notes)
                    <div class="mt-3 bg-white rounded-xl p-3 border border-[rgba(38,166,154,0.2)]">
                        <p class="text-xs text-slate-400 mb-1">Notes</p>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $client->notes }}</p>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            {{-- Appointment History --}}
            <div class="bg-slate-50 rounded-2xl p-4 border border-[rgba(38,166,154,0.2)]">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-sm font-bold text-slate-700">Appointment History ({{ $client->appointments->count() }})</h3>
                </div>
                <div class="space-y-2">
                    @forelse($client->appointments as $appointment)
                    @php
                        $sc = match($appointment->status) {
                            'Scheduled' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'Confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Cancelled' => 'bg-red-50 text-red-700 border-red-200',
                            default     => 'bg-slate-100 text-slate-600 border-[rgba(38,166,154,0.25)]',
                        };
                    @endphp
                    <div class="flex items-center justify-between bg-white rounded-xl px-3.5 py-2.5 border border-[rgba(38,166,154,0.2)]">
                        <div>
                            <p class="text-xs font-semibold text-slate-700">{{ $appointment->service_type }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $appointment->appointment_date->format('M d, Y') }} · {{ $appointment->formatted_time }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold border {{ $sc }}">{{ $appointment->status }}</span>
                            <a href="{{ route('appointments.show', $appointment) }}" class="text-[11px] font-bold text-[#26a69a] hover:underline">Open</a>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic">No appointments yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Service Records --}}
            @if($client->serviceRecords->count())
            <div class="bg-slate-50 rounded-2xl p-4 border border-[rgba(38,166,154,0.2)]">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-[#ff8a65]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-sm font-bold text-slate-700">Service Records ({{ $client->serviceRecords->count() }})</h3>
                </div>
                <div class="space-y-2">
                    @foreach($client->serviceRecords->take(3) as $record)
                    <div class="bg-white rounded-xl px-3.5 py-2.5 border border-[rgba(38,166,154,0.2)]">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-xs font-semibold text-slate-700">{{ $record->staff->name }}</p>
                            <p class="text-[11px] text-slate-400">{{ $record->service_date->format('M d, Y') }}</p>
                        </div>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $record->description }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Delete action (admin only) --}}
            @if(auth()->user()->isAdmin())
            <form method="POST" action="{{ route('clients.destroy', $client) }}"
                onsubmit="return confirm('Are you sure? This cannot be undone.')" class="pt-1">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 transition-colors">
                    Delete Client Record
                </button>
            </form>
            @endif

        </div>
    </div>

    {{-- ===================== EDIT CLIENT MODAL ===================== --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isReceptionist())
    <div id="editModal" class="hidden relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        {{-- Modal Header --}}
        <div class="flex items-center gap-3 p-6 pb-4">
            <div class="w-10 h-10 rounded-xl bg-[#E8F5F3] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div class="flex-1">
                <h2 class="text-sm font-bold text-slate-800">Edit Client</h2>
                <p class="text-xs text-slate-500 mt-0.5">Update {{ $client->full_name }}'s information</p>
            </div>
            <button onclick="document.getElementById('editModal').classList.add('hidden');document.getElementById('viewModal').classList.remove('hidden')"
                class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('clients.update', $client) }}" class="px-6 pb-6">
            @csrf @method('PUT')

            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-3">
                <ul class="text-xs text-red-600 space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name', $client->first_name) }}" placeholder="e.g., John"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name', $client->last_name) }}" placeholder="e.g., Smith"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $client->email) }}" placeholder="john.smith@email.com"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" placeholder="(555) 123-4567"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Address</label>
                    <input type="text" name="address" value="{{ old('address', $client->address) }}" placeholder="123 Main St, Anytown, USA"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
            </div>

            <div class="border-t border-[rgba(38,166,154,0.2)] my-4"></div>
            <p class="text-sm font-bold text-slate-700 mb-3">Pet Information</p>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Pet Name <span class="text-red-500">*</span></label>
                    <input type="text" name="pet_name" value="{{ old('pet_name', $client->pet_name) }}" placeholder="e.g., Max" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Species <span class="text-red-500">*</span></label>
                    <input type="text" name="pet_species" value="{{ old('pet_species', $client->pet_species) }}" placeholder="e.g., Dog" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Breed</label>
                    <input type="text" name="pet_breed" value="{{ old('pet_breed', $client->pet_breed) }}" placeholder="e.g., Golden Retriever"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
            </div>

            <div class="mt-3">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Notes</label>
                <textarea name="notes" rows="2" placeholder="Additional notes or special instructions..."
                    class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors resize-none">{{ old('notes', $client->notes) }}</textarea>
            </div>

            <div class="flex gap-2 mt-5">
                <button type="submit" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 bg-[#26a69a] text-white text-sm font-bold rounded-xl hover:bg-[#1f8c82] transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden');document.getElementById('viewModal').classList.remove('hidden')"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">Cancel</button>
            </div>
        </form>
    </div>
    @endif
</div>

{{-- Auto-open edit modal on validation errors --}}
@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('viewModal')?.classList.add('hidden');
    document.getElementById('editModal')?.classList.remove('hidden');
});
</script>
@endif

@endsection
