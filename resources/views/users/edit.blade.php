@extends('layouts.app')

@section('title', 'Edit User')

@php
    $roleLabel = [
        'admin'        => 'Admin',
        'staff'        => 'Veterinarian',
        'receptionist' => 'Receptionist',
    ];
@endphp

@section('content')

<div class="fixed inset-0 z-40 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="flex items-center gap-3 p-6 pb-4">
            <div class="w-10 h-10 rounded-xl bg-[#E8F5F3] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div class="flex-1">
                <h2 class="text-sm font-bold text-slate-800">Edit Staff Member</h2>
                <p class="text-xs text-slate-500 mt-0.5">Update {{ $user->name }}'s account details</p>
            </div>
            <a href="{{ route('users.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}" class="px-6 pb-6">
            @csrf @method('PUT')

            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-3">
                <ul class="text-xs text-red-600 space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="e.g., James"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="e.g., Wilson"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="staff@furmend.com"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <select name="role" class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                        @foreach($roles as $r)
                        <option value="{{ $r }}" @selected(old('role', $user->role) === $r)>{{ $roleLabel[$r] ?? ucfirst($r) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $user->specialization) }}" placeholder="e.g., Surgery"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="09171234567"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">New Password</label>
                    <input type="password" name="password" autocomplete="new-password"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                    <p class="text-[11px] text-slate-400 mt-1">Leave blank to keep current password.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" autocomplete="new-password"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                </div>
            </div>

            <div class="flex gap-2 mt-5">
                <button type="submit" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 bg-[#26a69a] text-white text-sm font-bold rounded-xl hover:bg-[#1f8c82] transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
                <a href="{{ route('users.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors text-center">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
