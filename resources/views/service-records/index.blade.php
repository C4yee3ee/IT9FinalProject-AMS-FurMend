@extends('layouts.app')
@section('title', 'Service Records')
@section('content')

    {{-- Header Banner --}}
    <div class="rounded-2xl p-5 text-white shadow-md mb-4 relative overflow-hidden"
        style="background:linear-gradient(to right,#26A69A,#4DB6AC)">
        <div class="flex items-start justify-between relative z-10">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h1 class="text-xl font-bold">Service Records</h1>
                </div>
                <p class="text-xs text-white/80">View and manage appointment notes and outcomes</p>
            </div>
            @if($canCreateServiceRecord)
                <button onclick="document.getElementById('createModal').classList.remove('hidden')"
                    class="flex items-center gap-1.5 bg-white text-[#26a69a] px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-50 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Service Record
                </button>
            @endif
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-3 mt-4 relative z-10">
            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Total Records</p>
                </div>
                <p class="text-lg font-extrabold">{{ $totalRecords }}</p>
            </div>
            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">This Month</p>
                </div>
                <p class="text-lg font-extrabold">{{ $thisMonth }}</p>
            </div>
            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Active Clients</p>
                </div>
                <p class="text-lg font-extrabold">{{ $activeClients }}</p>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] overflow-hidden mb-4">
        <form method="GET" class="flex h-11">
            <label class="relative flex items-center flex-1">
                <svg class="absolute left-4 h-4 w-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Search by client name, staff, or description..."
                    class="w-full h-full pl-11 pr-4 bg-white text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-slate-50 transition-colors border-r border-[rgba(38,166,154,0.2)]">
            </label>
            <button type="submit"
                class="px-5 bg-[#26a69a] text-white text-xs font-bold hover:bg-[#1f8c82] transition-colors shrink-0">Search</button>
            @if($search)
                <a href="{{ route('service-records.index') }}"
                    class="px-4 flex items-center bg-slate-50 text-slate-500 text-xs font-bold hover:bg-slate-100 transition-colors shrink-0">Reset</a>
            @endif
        </form>
    </div>

    <p class="text-xs text-slate-500 mb-3 px-1">Showing <span
            class="font-bold text-slate-700">{{ $serviceRecords->total() }}</span> service
        record{{ $serviceRecords->total() !== 1 ? 's' : '' }}</p>

    {{-- Record Cards --}}
    <div class="flex flex-col gap-3">
        @forelse($serviceRecords as $record)
            <div
                class="bg-white rounded-2xl border-l-4 border-l-[#26a69a] border border-[rgba(38,166,154,0.2)] shadow-md p-4 hover:shadow-md transition-shadow">
                {{-- Top Row --}}
                <div class="flex items-start justify-between gap-4 mb-3">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-lg bg-[#E8F5F3] flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="font-bold text-sm text-slate-800">{{ $record->client->full_name }}</p>
                                <span
                                    class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#E8F5F3] text-[#26a69a] border border-[#26a69a]/20">Rec-{{ $record->id }}</span>
                            </div>
                            <div class="flex items-center gap-4 mt-1 flex-wrap">
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $record->staff->name }}
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $record->service_date->format('Y-m-d') }}
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Appointment: apt-{{ $record->appointment_id }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="pl-12 space-y-2">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-0.5">Description:</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $record->description }}</p>
                    </div>

                    @if($record->remarks)
                        <div class="bg-amber-50/60 border border-amber-100 rounded-xl px-3.5 py-2.5">
                            <p class="text-xs font-semibold text-amber-600 mb-0.5">Remarks:</p>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $record->remarks }}</p>
                        </div>
                    @endif

                    <p class="text-[11px] text-slate-400 pt-1">Created on: {{ $record->created_at->format('Y-m-d') }}</p>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-[rgba(38,166,154,0.2)] p-10 text-center shadow-sm">
                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-slate-500 text-sm font-medium">No service records have been logged yet.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $serviceRecords->links() }}</div>

    {{-- ===================== ADD SERVICE RECORD MODAL ===================== --}}
    @if($canCreateServiceRecord)
        <div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                onclick="document.getElementById('createModal').classList.add('hidden')"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                {{-- Modal Header --}}
                <div class="flex items-center gap-3 p-6 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#E8F5F3] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-sm font-bold text-slate-800">Add Service Record</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Record notes and outcomes for a completed appointment</p>
                    </div>
                    <button onclick="document.getElementById('createModal').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('service-records.store') }}" class="px-6 pb-6">
                    @csrf
                    @if($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-3">
                            <ul class="text-xs text-red-600 space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Completed Appointment <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="appointment_id" required
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors appearance-none cursor-pointer">
                                    <option value="">Select an appointment</option>
                                    @foreach($availableAppointments as $apt)
                                        <option value="{{ $apt->id }}" @selected(old('appointment_id') == $apt->id)>
                                            {{ $apt->client->full_name }} — {{ $apt->service_type }}
                                            ({{ $apt->appointment_date->format('M d, Y') }})
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <input type="hidden" name="service_date" value="{{ now()->format('Y-m-d') }}">

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Description <span
                                    class="text-red-500">*</span></label>
                            <textarea name="description" rows="3" required
                                placeholder="Describe the service provided, diagnosis, treatment, etc."
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors resize-none">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Remarks / Outcome</label>
                            <textarea name="remarks" rows="3"
                                placeholder="Additional remarks, follow-up instructions, observations..."
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors resize-none">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-5">
                        <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')"
                            class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">Cancel</button>
                        <button type="submit"
                            class="flex items-center gap-1.5 px-5 py-2.5 bg-[#26a69a] text-white text-sm font-bold rounded-xl hover:bg-[#1f8c82] transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Auto-open modal on validation errors --}}
    @if($errors->any())
        <script>document.addEventListener('DOMContentLoaded', () => document.getElementById('createModal')?.classList.remove('hidden'));</script>
    @endif

@endsection