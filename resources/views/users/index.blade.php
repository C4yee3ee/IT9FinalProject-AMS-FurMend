@extends('layouts.app')
@section('title', 'Staff')
@section('content')

    @php
        $roleBadge = [
            'admin' => 'bg-[#E8F5F3] text-[#26a69a] border-[#26a69a]/20',
            'staff' => 'bg-blue-50 text-blue-700 border-blue-200',
            'receptionist' => 'bg-slate-100 text-slate-600 border-[rgba(38,166,154,0.25)]',
        ];
        $roleLabel = [
            'admin' => 'Admin',
            'staff' => 'Veterinarian',
            'receptionist' => 'Receptionist',
        ];
    @endphp

    {{-- Header Banner --}}
    <div class="rounded-2xl p-5 text-white shadow-md mb-4 relative overflow-hidden"
        style="background:linear-gradient(to right,#26A69A,#4DB6AC)">
        <div class="flex items-start justify-between relative z-10">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h1 class="text-xl font-bold">Staff Management</h1>
                </div>
                <p class="text-xs text-white/80">Manage staff members and roles</p>
            </div>
            <button onclick="document.getElementById('createUserModal').classList.remove('hidden')"
                class="flex items-center gap-1.5 bg-white text-[#26a69a] px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Staff Member
            </button>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-3 mt-4 relative z-10">
            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Total Staff</p>
                </div>
                <p class="text-lg font-extrabold">{{ $roleStats['total'] }}</p>
            </div>
            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Veterinarians</p>
                </div>
                <p class="text-lg font-extrabold">{{ $roleStats['staff'] }}</p>
            </div>
            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Receptionists</p>
                </div>
                <p class="text-lg font-extrabold">{{ $roleStats['receptionist'] }}</p>
            </div>
        </div>
    </div>

    {{-- Search + Role Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] overflow-hidden mb-4">
        <form method="GET" class="flex h-11">
            <label class="relative flex items-center flex-1 border-r border-[rgba(38,166,154,0.2)]">
                <svg class="absolute left-4 h-4 w-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email..."
                    class="w-full h-full pl-11 pr-4 bg-white text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-slate-50 transition-colors">
            </label>
            <div class="relative border-r border-[rgba(38,166,154,0.2)]">
                <select name="role" onchange="this.form.submit()"
                    class="h-full pl-4 pr-8 bg-white text-sm text-slate-600 focus:outline-none appearance-none cursor-pointer min-w-[140px]">
                    <option value="">All Roles</option>
                    @foreach($roles as $r)
                        <option value="{{ $r }}" @selected($selectedRole === $r)>{{ $roleLabel[$r] ?? ucfirst($r) }}</option>
                    @endforeach
                </select>
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <button type="submit"
                class="px-5 bg-[#26a69a] text-white text-xs font-bold hover:bg-[#1f8c82] transition-colors shrink-0">Search</button>
            @if($search || $selectedRole)
                <a href="{{ route('users.index') }}"
                    class="px-4 flex items-center bg-slate-50 text-slate-500 text-xs font-bold hover:bg-slate-100 transition-colors shrink-0">Reset</a>
            @endif
        </form>
    </div>

    {{-- Staff Cards Grid --}}
    <div class="grid gap-4 md:grid-cols-2">
        @forelse($users as $managedUser)
            <div
                class="bg-white rounded-2xl border border-[rgba(38,166,154,0.2)] shadow-md p-4 hover:shadow-md transition-shadow">
                {{-- Top row: name + status --}}
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-full bg-[#E8F5F3] flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-sm text-slate-800 truncate">{{ $managedUser->name }}</p>
                            <span
                                class="inline-block mt-1 px-2 py-0.5 rounded-md text-[10px] font-bold border {{ $roleBadge[$managedUser->role] ?? 'bg-slate-100 text-slate-600 border-[rgba(38,166,154,0.25)]' }}">
                                {{ $roleLabel[$managedUser->role] ?? ucfirst($managedUser->role) }}
                            </span>
                        </div>
                    </div>
                    <span
                        class="px-2.5 py-0.5 rounded-md text-[10px] font-bold shrink-0 {{ $managedUser->is_active ? 'bg-[#E8F5F3] text-[#26a69a] border border-[#26a69a]/20' : 'bg-red-50 text-red-600 border border-red-200' }}">
                        {{ $managedUser->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                {{-- Details --}}
                <div class="space-y-1.5 mb-3 pl-12">
                    @if($managedUser->specialization)
                        <p class="text-xs text-slate-600"><span class="font-semibold text-slate-700">Specialization:</span>
                            {{ $managedUser->specialization }}</p>
                    @endif
                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                        <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $managedUser->email }}
                    </div>
                    @if($managedUser->phone)
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $managedUser->phone }}
                        </div>
                    @endif
                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                        <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Joined {{ $managedUser->created_at->format('Y-m-d') }}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2 pl-12" id="user-actions-{{ $managedUser->id }}">
                    <button type="button"
                        onclick="toggleUserActive({{ $managedUser->id }}, 1, '{{ route('users.toggle-active', $managedUser) }}', this)"
                        class="px-3 py-1 rounded-lg text-[11px] font-bold transition-colors {{ $managedUser->is_active ? 'bg-[#26a69a] text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}"
                        data-active="{{ $managedUser->is_active ? '1' : '0' }}">
                        Active
                    </button>
                    <button type="button"
                        onclick="toggleUserActive({{ $managedUser->id }}, 0, '{{ route('users.toggle-active', $managedUser) }}', this)"
                        class="px-3 py-1 rounded-lg text-[11px] font-bold transition-colors {{ !$managedUser->is_active ? 'bg-red-500 text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}"
                        data-active="{{ $managedUser->is_active ? '1' : '0' }}">
                        Inactive
                    </button>
                    <a href="{{ route('users.edit', $managedUser) }}"
                        class="ml-auto px-3 py-1 rounded-lg text-[11px] font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors">Edit</a>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 bg-white rounded-2xl border border-[rgba(38,166,154,0.2)] p-10 text-center shadow-sm">
                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-slate-500 text-sm font-medium">No staff members matched your filters.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $users->links() }}</div>

    {{-- ===================== ADD STAFF MEMBER MODAL ===================== --}}
    <div id="createUserModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
            onclick="document.getElementById('createUserModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center gap-3 p-6 pb-4">
                <div class="w-10 h-10 rounded-xl bg-[#E8F5F3] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-sm font-bold text-slate-800">Add Staff Member</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Create an account with the appropriate system role</p>
                </div>
                <button onclick="document.getElementById('createUserModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('users.store') }}" class="px-6 pb-6">
                @csrf
                @if($errors->any())
                    <div class="alert alert-error mb-4">
                        <ul class="text-xs space-y-0.5">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">First Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="e.g., James"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Last Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="e.g., Wilson"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Address <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="staff@furmend.com"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Role <span
                                class="text-red-500">*</span></label>
                        <select name="role"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                            @foreach($roles as $r)
                                <option value="{{ $r }}" @selected(old('role', 'staff') === $r)>
                                    {{ $roleLabel[$r] ?? ucfirst($r) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Specialization</label>
                        <input type="text" name="specialization" value="{{ old('specialization') }}"
                            placeholder="e.g., Surgery"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="09171234567"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Password <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="password" autocomplete="new-password"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors pr-10">
                            <button type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#26a69a]"
                                onclick="togglePasswordVisibility(this)">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Minimum 8 characters.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Confirm Password <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" autocomplete="new-password"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors pr-10">
                            <button type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#26a69a]"
                                onclick="togglePasswordVisibility(this)">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="col-span-2 hidden"></div>
                </div>

                <div class="flex gap-2 mt-5">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-[#26a69a] text-white text-sm font-bold rounded-xl hover:bg-[#1f8c82] transition-colors shadow-sm">Create
                        Staff Member</button>
                    <button type="button" onclick="document.getElementById('createUserModal').classList.add('hidden')"
                        class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @if($errors->any())
        <script>document.addEventListener('DOMContentLoaded', () => document.getElementById('createUserModal')?.classList.remove('hidden'));</script>
    @endif

    <script>
        function togglePasswordVisibility(button) {
            const input = button.parentElement.querySelector('input');
            const icon = button.querySelector('svg');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }

        function toggleUserActive(userId, setActive, url, clickedBtn) {
            const container = document.getElementById('user-actions-' + userId);
            const [activeBtn, inactiveBtn] = container.querySelectorAll('button[type="button"]');

            // Optimistic UI update
            const isNowActive = setActive === 1;
            activeBtn.className   = 'px-3 py-1 rounded-lg text-[11px] font-bold transition-colors ' + (isNowActive  ? 'bg-[#26a69a] text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200');
            inactiveBtn.className = 'px-3 py-1 rounded-lg text-[11px] font-bold transition-colors ' + (!isNowActive ? 'bg-red-500 text-white'    : 'bg-slate-100 text-slate-500 hover:bg-slate-200');

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': csrfToken },
                body: '_method=PATCH&set_active=' + setActive,
            })
            .then(res => {
                if (res.ok || res.redirected) {
                    if (typeof showToast === 'function') {
                        showToast('success', 'Status Updated', 'Staff member status has been updated.');
                    }
                } else {
                    throw new Error('Request failed');
                }
            })
            .catch(() => {
                // Revert on failure
                activeBtn.className   = 'px-3 py-1 rounded-lg text-[11px] font-bold transition-colors ' + (!isNowActive ? 'bg-[#26a69a] text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200');
                inactiveBtn.className = 'px-3 py-1 rounded-lg text-[11px] font-bold transition-colors ' + (isNowActive  ? 'bg-red-500 text-white'    : 'bg-slate-100 text-slate-500 hover:bg-slate-200');
                if (typeof showToast === 'function') {
                    showToast('error', 'Error', 'Could not update staff status. Please try again.');
                }
            });
        }
    </script>

@endsection