@extends('layouts.app')
@section('title', 'Clients')
@section('content')

    {{-- Header Banner --}}
    <div class="rounded-2xl p-5 text-white shadow-md mb-5 relative overflow-hidden"
        style="background:linear-gradient(to right,#26A69A,#4DB6AC)">
        <div class="flex items-start justify-between relative z-10">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h1 class="text-xl font-bold">Client Management</h1>
                </div>
                <p class="text-xs text-white/80">Manage client records and contact information</p>
            </div>
            @if(auth()->user()->isAdmin() || auth()->user()->isReceptionist())
                <button onclick="document.getElementById('createModal').classList.remove('hidden')"
                    class="flex items-center gap-1.5 bg-white text-[#26a69a] px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-50 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Client
                </button>
            @endif
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-3 mt-5 relative z-10">
            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Total Clients</p>
                </div>
                <p class="text-lg font-extrabold">{{ $totalClients }}</p>
            </div>
            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Pets Registered</p>
                </div>
                <p class="text-lg font-extrabold">{{ $totalClients }}</p>
            </div>
            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">New This Month</p>
                </div>
                <p class="text-lg font-extrabold">{{ $newThisMonth }}</p>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] overflow-hidden mb-4">
        <form method="GET" class="flex h-11">
            <label class="relative flex items-center flex-1 border-r border-[rgba(38,166,154,0.2)]">
                <svg class="absolute left-4 h-4 w-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, email, or phone..."
                    class="w-full h-full pl-11 pr-4 bg-white text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-slate-50 transition-colors">
            </label>
            <button type="submit"
                class="px-5 bg-[#26a69a] text-white text-xs font-bold hover:bg-[#1f8c82] transition-colors shrink-0">Search</button>
            @if($search)
                <a href="{{ route('clients.index') }}"
                    class="px-4 flex items-center bg-slate-50 text-slate-500 text-xs font-bold hover:bg-slate-100 transition-colors shrink-0">Reset</a>
            @endif
        </form>
    </div>

    <p class="text-xs text-slate-500 mb-3 px-1">Showing <span
            class="font-bold text-slate-700">{{ $clients->total() }}</span> client{{ $clients->total() !== 1 ? 's' : '' }}
    </p>

    {{-- Client Cards --}}
    <div class="flex flex-col gap-3">
        @forelse($clients as $client)
            <div
                class="bg-white rounded-2xl border border-[rgba(38,166,154,0.2)] shadow-md p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        <div class="w-9 h-9 rounded-full bg-[#E8F5F3] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-sm text-slate-800">{{ $client->full_name }}</p>
                            @if($client->pet_name)
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <svg class="w-3 h-3 text-[#26a69a] shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <p class="text-xs text-slate-500">
                                        {{ $client->pet_name }}{{ $client->pet_species ? ' – ' . $client->pet_species : '' }}{{ $client->pet_breed ? ' (' . $client->pet_breed . ')' : '' }}
                                    </p>
                                </div>
                            @endif

                            <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 mt-2.5">
                                @if($client->email)
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                        <svg class="w-3.5 h-3.5 text-[#26a69a] shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $client->email }}
                                    </div>
                                @endif
                                @if($client->phone)
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                        <svg class="w-3.5 h-3.5 text-[#26a69a] shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $client->phone }}
                                    </div>
                                @endif
                                @if($client->address)
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                        <svg class="w-3.5 h-3.5 text-[#26a69a] shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $client->address }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('clients.show', $client) }}"
                        class="flex items-center gap-1.5 px-3 py-1.5 border border-[rgba(38,166,154,0.25)] rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-colors shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-[rgba(38,166,154,0.2)] p-10 text-center shadow-sm">
                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-slate-500 text-sm font-medium">No clients matched your search.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $clients->links() }}</div>

    {{-- ===================== ADD NEW CLIENT MODAL ===================== --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isReceptionist())
        <div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                onclick="document.getElementById('createModal').classList.add('hidden')"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                {{-- Modal Header --}}
                <div class="flex items-center gap-3 p-6 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#E8F5F3] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-sm font-bold text-slate-800">Add New Client</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Enter the client's information to create a new record</p>
                    </div>
                    <button onclick="document.getElementById('createModal').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('clients.store') }}" class="px-6 pb-6">
                    @csrf
                    @if($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-3">
                            <ul class="text-xs text-red-600 space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">First Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="e.g., John"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Last Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="e.g., Smith"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="john.smith@email.com"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="(555) 123-4567"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                placeholder="123 Main St, Anytown, USA"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                        </div>
                    </div>

                    <div class="border-t border-[rgba(38,166,154,0.2)] my-4"></div>
                    <p class="text-sm font-bold text-slate-700 mb-3">Pet Information</p>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Pet Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pet_name" value="{{ old('pet_name') }}" placeholder="e.g., Max" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Species <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pet_species" value="{{ old('pet_species') }}" placeholder="e.g., Dog"
                                required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Breed</label>
                            <input type="text" name="pet_breed" value="{{ old('pet_breed') }}"
                                placeholder="e.g., Golden Retriever"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Notes</label>
                        <textarea name="notes" rows="2" placeholder="Additional notes or special instructions..."
                            class="w-full px-3 py-2.5 bg-slate-50 border border-[rgba(38,166,154,0.25)] rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#26a69a] focus:border-[#26a69a] focus:bg-white transition-colors resize-none">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex gap-2 mt-5">
                        <button type="submit"
                            class="flex-1 py-2.5 bg-[#26a69a] text-white text-sm font-bold rounded-xl hover:bg-[#1f8c82] transition-colors shadow-sm">Save
                            Client</button>
                        <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')"
                            class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Auto-open create modal on validation errors --}}
    @if($errors->any())
        <script>document.addEventListener('DOMContentLoaded', () => document.getElementById('createModal')?.classList.remove('hidden'));</script>
    @endif

@endsection