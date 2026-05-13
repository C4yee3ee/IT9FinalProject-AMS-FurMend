@extends('layouts.app')

@section('title', 'Schedule New Appointment')

@section('content')
    <!-- Modal backdrop -->
    <div class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm flex items-start justify-center p-4 sm:p-6 overflow-y-auto">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl relative border border-[rgba(38,166,154,0.2)] my-6">

            <!-- Header -->
            <div class="flex items-start justify-between px-6 py-5 border-b border-[rgba(38,166,154,0.2)]">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-[#e8f5f3] rounded-xl">
                        <svg class="w-6 h-6 text-[#26a69a]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                            <line x1="16" x2="16" y1="2" y2="6"/>
                            <line x1="8" x2="8" y1="2" y2="6"/>
                            <line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Schedule New Appointment</h2>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Fill in the details below to schedule a new appointment for a client</p>
                    </div>
                </div>
                <a href="{{ route('appointments.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors p-2 hover:bg-slate-50 rounded-full shrink-0">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Form Body -->
            <div class="p-6">
                <form method="POST" action="{{ route('appointments.store') }}">
                    @include('appointments._form')
                </form>
            </div>

        </div>
    </div>
@endsection