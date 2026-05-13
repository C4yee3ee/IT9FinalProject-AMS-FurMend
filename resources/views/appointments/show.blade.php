@extends('layouts.app')

@section('title', 'Appointment #'.$appointment->id)

@section('content')
    <!-- Modal backdrop -->
    <div class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm flex items-start justify-center p-4 sm:p-6 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl relative border border-[rgba(38,166,154,0.2)] my-6">

            <!-- Header -->
            <div class="flex items-start justify-between px-6 py-5 border-b border-[rgba(38,166,154,0.2)]">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-[#e8f5f3] rounded-xl">
                        <svg class="w-6 h-6 text-[#26a69a]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Appointment #{{ $appointment->id }}</h2>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Review the booking details, status, and linked service record</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @if ($canManageAppointment && $appointment->status !== \App\Models\Appointment::STATUS_COMPLETED)
                        <a href="{{ route('appointments.edit', $appointment) }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Edit
                        </a>
                    @endif
                    <a href="{{ route('appointments.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors p-2 hover:bg-slate-50 rounded-full">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </a>
                </div>
            </div>

            <!-- Body: two-column on large screens -->
            <div class="grid md:grid-cols-[1fr_280px] divide-y md:divide-y-0 md:divide-x divide-slate-100">

                <!-- Left: Appointment Details -->
                <div class="p-6 space-y-5">
                    <!-- Status badge + creator -->
                    @php
                        $pillClass = match($appointment->status) {
                            'Scheduled' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'Confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Cancelled' => 'bg-red-50 text-red-600 border-red-200',
                            'No Show'   => 'bg-slate-100 text-slate-600 border-slate-200',
                            default     => 'bg-slate-100 text-slate-600 border-slate-200',
                        };
                    @endphp
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold border uppercase tracking-wide {{ $pillClass }}">
                            {{ $appointment->status }}
                        </span>
                        <span class="text-[11px] text-slate-400">Created by {{ $appointment->creator->name }}</span>
                    </div>

                    <!-- Info grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-slate-50 px-4 py-3">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Client</p>
                            <p class="text-sm font-bold text-slate-900">{{ $appointment->client->full_name }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $appointment->client->phone }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 px-4 py-3">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Assigned Staff</p>
                            <p class="text-sm font-bold text-slate-900">{{ $appointment->staff->name }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ ucfirst($appointment->staff->role) }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 px-4 py-3">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Service Type</p>
                            <p class="text-sm font-bold text-slate-900">{{ $appointment->service_type }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 px-4 py-3">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Schedule</p>
                            <p class="text-sm font-bold text-slate-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $appointment->formatted_time }}</p>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if ($appointment->notes)
                        <div class="bg-[#fffdf0] border border-[#fef0c7] rounded-xl px-4 py-3">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-amber-600 mb-1">Notes</p>
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $appointment->notes }}</p>
                        </div>
                    @else
                        <div class="bg-slate-50 border border-dashed border-[rgba(38,166,154,0.25)] rounded-xl px-4 py-3 text-sm text-slate-400 italic">
                            No booking notes added yet.
                        </div>
                    @endif

                    <!-- Linked Service Record -->
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Linked Service Record</p>
                        @if ($appointment->serviceRecord)
                            <div class="rounded-xl border border-[#26a69a]/20 bg-[#e8f5f3]/50 px-4 py-3">
                                <p class="text-xs font-bold text-[#1f8c82]">{{ $appointment->serviceRecord->service_date->format('M d, Y') }}</p>
                                <p class="mt-1 text-xs leading-5 text-slate-600">{{ $appointment->serviceRecord->description }}</p>
                                @if ($appointment->serviceRecord->remarks)
                                    <p class="mt-2 text-xs text-slate-400 italic">{{ $appointment->serviceRecord->remarks }}</p>
                                @endif
                            </div>
                        @elseif ($appointment->status === \App\Models\Appointment::STATUS_COMPLETED)
                            <div class="rounded-xl border border-dashed border-[rgba(38,166,154,0.25)] bg-slate-50 px-4 py-3 text-xs text-slate-400">
                                No service record attached yet.
                                @if (auth()->user()->isAdmin() || auth()->user()->isStaff())
                                    <a href="{{ route('service-records.create') }}" class="mt-2 inline-flex items-center gap-1 text-[#26a69a] font-bold hover:underline">
                                        Create Service Record
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="rounded-xl border border-dashed border-[rgba(38,166,154,0.25)] bg-slate-50 px-4 py-3 text-xs text-slate-400">
                                Service records can be created after the appointment is marked as completed.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Status Update Panel -->
                <div class="p-6 flex flex-col gap-5">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Status Tracking</p>
                        <h3 class="text-sm font-bold text-slate-800">Update Status</h3>
                    </div>

                    <form method="POST" action="{{ route('appointments.update-status', $appointment) }}" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5" for="status">Current Status</label>
                            <div class="relative">
                                <select id="status" name="status" class="block w-full pl-4 pr-10 py-2.5 border border-[rgba(38,166,154,0.25)] rounded-xl bg-white focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] sm:text-sm text-slate-700 appearance-none font-medium transition-colors cursor-pointer">
                                    @foreach (\App\Models\Appointment::STATUSES as $status)
                                        <option value="{{ $status }}" @selected($appointment->status === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full px-4 py-2.5 bg-[#26a69a] text-white font-bold rounded-xl text-sm hover:bg-[#1f8c82] transition-colors shadow-sm">
                            Save Status
                        </button>
                    </form>

                    <!-- Quick action: Reschedule / Reassign (hidden for completed appointments) -->
                    @if ($canManageAppointment && $appointment->status !== \App\Models\Appointment::STATUS_COMPLETED)
                        <div class="pt-4 border-t border-[rgba(38,166,154,0.2)]">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-3">Quick Actions</p>
                            <a href="{{ route('appointments.edit', $appointment) }}"
                               class="flex items-center gap-2.5 w-full px-4 py-2.5 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:border-[#26a69a]/30 transition-colors">
                                <svg class="w-4 h-4 text-[#26a69a]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 2v4M16 2v4"/>
                                </svg>
                                Reschedule Appointment
                            </a>
                            <a href="{{ route('appointments.edit', $appointment) }}"
                               class="mt-2 flex items-center gap-2.5 w-full px-4 py-2.5 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:border-[#26a69a]/30 transition-colors">
                                <svg class="w-4 h-4 text-[#26a69a]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                Reassign Staff
                            </a>
                        </div>
                    @elseif ($appointment->status === \App\Models\Appointment::STATUS_COMPLETED)
                        <div class="pt-4 border-t border-[rgba(38,166,154,0.2)]">
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-amber-50 border border-amber-100 text-xs text-amber-700 font-medium">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                                Completed appointments cannot be edited.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
