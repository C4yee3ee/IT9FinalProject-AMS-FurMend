<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ trim($__env->yieldContent('title')) ? trim($__env->yieldContent('title')) . ' | ' : '' }}{{ $appSettings['system_name'] ?? 'FurMend Appointment System' }}
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8FAFC] font-sans antialiased text-[#2C3E50]">
    @php
        $user = auth()->user();
        $navigation = [
            ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => 'dashboard', 'show' => true, 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['label' => 'Appointments', 'route' => 'appointments.index', 'active' => 'appointments.*', 'show' => true, 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['label' => 'Clients', 'route' => 'clients.index', 'active' => 'clients.*', 'show' => $user->isAdmin() || $user->isReceptionist(), 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
            ['label' => 'Service Records', 'route' => 'service-records.index', 'active' => 'service-records.*', 'show' => true, 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['label' => 'Staff', 'route' => 'users.index', 'active' => 'users.*', 'show' => $user->isAdmin(), 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            ['label' => 'Reports', 'route' => 'reports.index', 'active' => 'reports.*', 'show' => $user->isAdmin(), 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
        ];
    @endphp

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside class="hidden lg:flex flex-col w-64 bg-white border-r border-[rgba(38,166,154,0.2)] relative z-20">
            <!-- Header (Logo area) -->
            <div class="h-[76px] flex items-center px-6">
                <img src="{{ asset('assets/furmend-logo.png') }}" alt="Logo" class="h-11 w-auto mr-3 drop-shadow-sm">
                <div class="flex flex-col">
                    <span class="font-extrabold text-[#2C3E50] text-lg leading-none tracking-tight">FurMend</span>
                    <span class="text-xs text-[#26A69A] font-bold uppercase tracking-wider mt-1">Pet Care
                        System</span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-4 space-y-1 mt-2">
                @foreach ($navigation as $item)
                    @if ($item['show'])
                        <a href="{{ route($item['route']) }}"
                            class="flex items-center px-4 py-3 rounded-[1.25rem] font-semibold text-sm transition-colors {{ request()->routeIs($item['active']) ? 'bg-[#E8F5F3] text-[#26A69A]' : 'text-[#5B7282] hover:bg-gray-50 hover:text-[#2C3E50]' }}">
                            <svg class="w-[1.15rem] h-[1.15rem] mr-3 {{ request()->routeIs($item['active']) ? 'text-[#26A69A]' : 'text-[#8AA2B3]' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}">
                                </path>
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <!-- Sidebar Footer: User Profile + Logout -->
            <div class="p-4 mt-auto border-t border-[rgba(38,166,154,0.2)]">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-[#E8F5F3] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#26A69A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-sm font-bold text-[#2C3E50] truncate">{{ $user->name }}</span>
                        <span class="text-xs text-[#8AA2B3] font-medium mt-0.5">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-white border border-[rgba(38,166,154,0.25)] hover:bg-gray-50 text-[#5B7282] hover:text-[#2C3E50] rounded-xl font-semibold text-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F8FAFC] relative"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%2326A69A\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">

            <!-- Top Header -->
            <header
                class="h-[76px] shrink-0 bg-white z-10 flex items-center justify-between px-6 lg:px-8 relative border-b border-[rgba(38,166,154,0.2)]"
                style="box-shadow: 0 2px 8px -2px rgba(38,166,154,0.08), 0 4px 12px -4px rgba(38,166,154,0.06)">
                <!-- Mobile Logo -->
                <div class="flex items-center lg:hidden">
                    <img src="{{ asset('assets/furmend-logo.png') }}" alt="Logo" class="h-10 w-auto mr-3">
                    <div class="flex flex-col">
                        <span class="font-extrabold text-[#2C3E50] text-lg leading-none tracking-tight">FurMend</span>
                    </div>
                </div>

                <!-- Spacer -->
                <div class="hidden lg:flex flex-1"></div>

                <!-- Right: Live Date & Time -->
                <div class="hidden sm:flex items-center gap-2 text-[#8AA2B3] text-sm font-medium">
                    <svg class="w-3.5 h-3.5 text-[#26A69A] opacity-70 shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span id="live-datetime" class="tracking-wide">Loading...</span>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 relative">

                <!-- Mobile Navigation (Only visible on small screens) -->
                <div
                    class="lg:hidden mb-6 bg-white rounded-2xl p-2 shadow-sm border border-[rgba(38,166,154,0.2)] overflow-x-auto whitespace-nowrap scrollbar-hide">
                    <div class="flex gap-2">
                        @foreach ($navigation as $item)
                            @if ($item['show'])
                                <a href="{{ route($item['route']) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all {{ request()->routeIs($item['active']) ? 'bg-[#E8F5F3] text-[#26A69A]' : 'bg-transparent text-[#5B7282] hover:bg-gray-50' }}">
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>
    <script>
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            };
            const datetimeEl = document.getElementById('live-datetime');
            if (datetimeEl) {
                datetimeEl.textContent = now.toLocaleString('en-US', options);
            }
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
    <div id="toast-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 999999; display: flex; flex-direction: column; gap: 12px; width: 100%; max-width: 384px; pointer-events: none;"></div>
    @include('partials.toast')
    @stack('scripts')
</body>

</html>