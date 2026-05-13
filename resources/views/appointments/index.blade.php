@extends('layouts.app')
@section('title', 'Appointments')
@section('content')

{{-- Header Banner --}}
<div class="rounded-2xl p-5 text-white shadow-md mb-4 relative overflow-hidden" style="background:linear-gradient(to right,#26A69A,#4DB6AC)">
    <div class="flex items-start justify-between relative z-10">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <h1 class="text-xl font-bold">Appointment Management</h1>
            </div>
            <p class="text-xs text-white/80">Manage and schedule client appointments</p>
        </div>
        @if($canManageAppointments)
        <a href="{{ route('appointments.create') }}"
            class="flex items-center gap-1.5 bg-white text-[#26a69a] px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Appointment
        </a>
        @endif
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-3 mt-4 relative z-10">
        <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Total</p>
            </div>
            <p class="text-lg font-extrabold">{{ $totalAppointments }}</p>
        </div>
        <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Today</p>
            </div>
            <p class="text-lg font-extrabold">{{ $todayAppointments }}</p>
        </div>
        <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Scheduled</p>
            </div>
            <p class="text-lg font-extrabold">{{ $scheduledAppointments }}</p>
        </div>
        <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Completed</p>
            </div>
            <p class="text-lg font-extrabold">{{ $completedAppointments }}</p>
        </div>
    </div>
</div>

{{-- Search + Status Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] overflow-hidden mb-4">
    <form method="GET" class="flex h-11">
        <label class="relative flex items-center flex-1 border-r border-[rgba(38,166,154,0.2)]">
            <svg class="absolute left-4 h-4 w-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by client or staff name..."
                class="w-full h-full pl-11 pr-4 bg-white text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-slate-50 transition-colors">
        </label>
        <div class="relative border-r border-[rgba(38,166,154,0.2)]">
            <select name="status" onchange="this.form.submit()"
                class="h-full pl-4 pr-8 bg-white text-sm text-slate-600 focus:outline-none appearance-none cursor-pointer min-w-[150px]">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <button type="submit" class="px-5 bg-[#26a69a] text-white text-xs font-bold hover:bg-[#1f8c82] transition-colors shrink-0">Search</button>
        @if($search || $selectedStatus)
        <a href="{{ route('appointments.index') }}" class="px-4 flex items-center bg-slate-50 text-slate-500 text-xs font-bold hover:bg-slate-100 transition-colors shrink-0">Reset</a>
        @endif
    </form>
</div>

<p class="text-xs text-slate-500 mb-3 px-1">Showing <span class="font-bold text-slate-700">{{ $appointments->total() }}</span> appointment{{ $appointments->total() !== 1 ? 's' : '' }}@if($selectedStatus) — <span class="font-bold text-[#26a69a]">{{ $selectedStatus }}</span>@endif</p>

@php
    $statusBadge = [
        'Scheduled' => 'bg-amber-50 text-amber-700 border-amber-200',
        'Confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
        'Completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'Cancelled' => 'bg-red-50 text-red-600 border-red-200',
        'No Show'   => 'bg-slate-100 text-slate-600 border-[rgba(38,166,154,0.25)]',
    ];
    $statusBorder = [
        'Scheduled' => 'border-l-amber-500',
        'Confirmed' => 'border-l-blue-500',
        'Completed' => 'border-l-emerald-500',
        'Cancelled' => 'border-l-red-500',
        'No Show'   => 'border-l-slate-400',
    ];
@endphp

{{-- Appointment Cards --}}
<div class="flex flex-col gap-3">
    @forelse($appointments as $appointment)
    <a href="{{ route('appointments.show', $appointment) }}"
        class="block bg-white rounded-2xl border-l-4 {{ $statusBorder[$appointment->status] ?? 'border-l-slate-300' }} border border-[rgba(38,166,154,0.2)] shadow-md p-4 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-3 flex-1 min-w-0">
                <div class="w-9 h-9 rounded-full bg-[#E8F5F3] flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="font-bold text-sm text-slate-800">{{ $appointment->client->full_name }}</p>
                        <span class="text-[11px] font-bold text-[#26a69a] uppercase tracking-wide">apt-{{ $appointment->id }}</span>
                    </div>
                    @if($appointment->service_type)
                    <p class="text-xs text-slate-400 mt-0.5">{{ $appointment->service_type }}</p>
                    @endif

                    <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 mt-2.5">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-[#26a69a] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $appointment->appointment_date->format('Y-m-d') }}
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-[#ff8a65] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $appointment->formatted_time }}
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-[#2c3e50] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $appointment->staff->name }}
                        </div>
                    </div>

                    @if($appointment->notes)
                    <div class="mt-2.5 bg-amber-50/60 border border-amber-100 rounded-xl px-3 py-2">
                        <p class="text-xs text-slate-600"><span class="font-bold text-amber-600">Note:</span> {{ $appointment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold border shrink-0 {{ $statusBadge[$appointment->status] ?? 'bg-slate-100 text-slate-600 border-[rgba(38,166,154,0.25)]' }}">
                {{ $appointment->status }}
            </span>
        </div>
    </a>
    @empty
    <div class="bg-white rounded-2xl border border-[rgba(38,166,154,0.2)] p-10 text-center shadow-sm">
        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <p class="text-slate-500 text-sm font-medium">No appointments matched your current filters.</p>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $appointments->links() }}</div>

@endsection
