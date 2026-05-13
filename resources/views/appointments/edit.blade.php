@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content')
    <!-- Modal backdrop -->
    <div class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm flex items-start justify-center p-4 sm:p-6 overflow-y-auto">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl relative border border-[rgba(38,166,154,0.2)] my-6">

            <!-- Header -->
            <div class="flex items-start justify-between px-6 py-5 border-b border-[rgba(38,166,154,0.2)]">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-[#e8f5f3] rounded-xl">
                        <svg class="w-6 h-6 text-[#26a69a]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Edit Appointment</h2>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Reschedule or update the booking details for appointment #{{ $appointment->id }}</p>
                    </div>
                </div>
                <a href="{{ route('appointments.show', $appointment) }}" class="text-slate-400 hover:text-slate-600 transition-colors p-2 hover:bg-slate-50 rounded-full shrink-0">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Form Body -->
            <div class="p-6">
                <form method="POST" action="{{ route('appointments.update', $appointment) }}">
                    @method('PUT')
                    @include('appointments._form')
                </form>
            </div>

        </div>
    </div>
@endsection