@extends('layouts.app')
@section('title', 'Reports')
@section('content')

{{-- Header Banner --}}
<div class="rounded-2xl p-5 text-white shadow-md mb-4 relative" style="background:linear-gradient(to right,#26A69A,#4DB6AC)">
    <div class="flex items-start justify-between relative z-10">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <h1 class="text-xl font-bold">Reports & Analytics</h1>
            </div>
            <p class="text-xs text-white/80">View appointment history, client visits, and staff performance at a glance.</p>
        </div>
        <!-- Export Dropdown -->
        <div id="exportDropdownWrap">
            <button id="exportBtn"
                class="flex items-center gap-1.5 bg-white text-[#26a69a] px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export CSV
                <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
        </div>

        <script>
            // Render dropdown at body level to escape all stacking contexts
            const exportMenu = document.createElement('div');
            exportMenu.id = 'exportMenu';
            exportMenu.style.cssText = 'display:none;position:fixed;z-index:9999;width:288px';
            exportMenu.className = 'bg-white rounded-2xl shadow-2xl border border-[rgba(38,166,154,0.2)] p-4 space-y-3';
            exportMenu.innerHTML = `
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Choose Export Type</p>
                <form method="GET" action="{{ route('reports.export') }}">
                    <input type="hidden" name="type" value="appointments">
                    <p class="text-xs font-bold text-slate-700 mb-1.5">📅 Appointments</p>
                    <div class="flex gap-1.5 mb-2">
                        <input type="date" name="date_from" class="flex-1 px-2 py-1.5 text-xs border border-[rgba(38,166,154,0.25)] rounded-lg text-slate-600 focus:outline-none focus:ring-1 focus:ring-[#26a69a]">
                        <input type="date" name="date_to" class="flex-1 px-2 py-1.5 text-xs border border-[rgba(38,166,154,0.25)] rounded-lg text-slate-600 focus:outline-none focus:ring-1 focus:ring-[#26a69a]">
                    </div>
                    <button type="submit" class="w-full py-1.5 bg-[#26a69a] text-white text-xs font-bold rounded-lg hover:bg-[#1f8c82] transition-colors">Download Appointments CSV</button>
                </form>
                <div class="border-t border-[rgba(38,166,154,0.15)] pt-3 space-y-2">
                    <a href="{{ route('reports.export', ['type' => 'clients']) }}" class="flex items-center gap-2 w-full py-2 px-3 bg-slate-50 hover:bg-slate-100 rounded-lg text-xs font-bold text-slate-700 transition-colors">
                        <svg class="w-3.5 h-3.5 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Download Clients CSV
                    </a>
                    <a href="{{ route('reports.export', ['type' => 'staff']) }}" class="flex items-center gap-2 w-full py-2 px-3 bg-slate-50 hover:bg-slate-100 rounded-lg text-xs font-bold text-slate-700 transition-colors">
                        <svg class="w-3.5 h-3.5 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Download Staff Activity CSV
                    </a>
                </div>
            `;
            document.body.appendChild(exportMenu);

            const btn = document.getElementById('exportBtn');
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const rect = btn.getBoundingClientRect();
                const menuW = 288;
                exportMenu.style.top  = (rect.bottom + 8) + 'px';
                exportMenu.style.left = (rect.right - menuW) + 'px';
                exportMenu.style.display = exportMenu.style.display === 'none' ? 'block' : 'none';
            });

            document.addEventListener('click', function(e) {
                if (!btn.contains(e.target) && !exportMenu.contains(e.target)) {
                    exportMenu.style.display = 'none';
                }
            });

            window.addEventListener('scroll', function() {
                exportMenu.style.display = 'none';
            }, true);
        </script>

    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-3 mt-4 relative z-10">
        <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Total Appointments</p>
            </div>
            <p class="text-lg font-extrabold">{{ $totalAppointments }}</p>
        </div>
        <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Completed</p>
            </div>
            <p class="text-lg font-extrabold">{{ $completedAppointments }}</p>
        </div>
        <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Total Clients</p>
            </div>
            <p class="text-lg font-extrabold">{{ $totalClients }}</p>
        </div>
        <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm border border-white/10">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-white/75 text-[10px] font-semibold uppercase tracking-wider">Service Records</p>
            </div>
            <p class="text-lg font-extrabold">{{ $totalServiceRecords }}</p>
        </div>
    </div>
</div>

{{-- Tabs --}}
<div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] overflow-hidden mb-4">
    <div class="flex" id="reportTabs">
        <button onclick="switchTab('daily')" data-tab="daily" class="report-tab report-tab-active flex-1 px-4 py-3 text-xs font-bold transition-colors">Daily Report</button>
        <button onclick="switchTab('completed')" data-tab="completed" class="report-tab flex-1 px-4 py-3 text-xs font-bold transition-colors border-l border-[rgba(38,166,154,0.2)]">Completed</button>
        <button onclick="switchTab('cancelled')" data-tab="cancelled" class="report-tab flex-1 px-4 py-3 text-xs font-bold transition-colors border-l border-[rgba(38,166,154,0.2)]">Cancelled</button>
        <button onclick="switchTab('staff')" data-tab="staff" class="report-tab flex-1 px-4 py-3 text-xs font-bold transition-colors border-l border-[rgba(38,166,154,0.2)]">Staff Activity</button>
        <button onclick="switchTab('clients')" data-tab="clients" class="report-tab flex-1 px-4 py-3 text-xs font-bold transition-colors border-l border-[rgba(38,166,154,0.2)]">Client Visits</button>
    </div>
</div>

@php
    $statusBadge = [
        'Scheduled' => 'bg-amber-50 text-amber-700 border-amber-200',
        'Confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
        'Completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'Cancelled' => 'bg-red-50 text-red-600 border-red-200',
        'No Show'   => 'bg-slate-100 text-slate-600 border-[rgba(38,166,154,0.25)]',
    ];
    $statusDot = [
        'Scheduled' => 'bg-amber-400',
        'Confirmed' => 'bg-blue-500',
        'Completed' => 'bg-emerald-500',
        'Cancelled' => 'bg-red-500',
        'No Show'   => 'bg-slate-400',
    ];
@endphp

{{-- ======================== TAB: Daily Report ======================== --}}
<div id="tab-daily" class="tab-panel">
    {{-- Daily Appointment Report --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-4 mb-4">
        <div class="flex items-center gap-2 mb-3 border-b border-[rgba(38,166,154,0.2)] pb-3">
            <svg class="w-4 h-4 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <h2 class="text-sm font-bold text-slate-800">Daily Appointment Report - {{ now()->format('Y-m-d') }}</h2>
        </div>
        <div class="space-y-2">
            @forelse($todaySchedule as $apt)
            <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                <div>
                    <p class="font-bold text-sm text-slate-800">{{ $apt->client->full_name }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $apt->service_type ?? 'General' }} • {{ $apt->formatted_time }} • {{ $apt->staff->name }}</p>
                </div>
                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold border {{ $statusBadge[$apt->status] ?? 'bg-slate-100 text-slate-600 border-[rgba(38,166,154,0.25)]' }}">{{ $apt->status }}</span>
            </div>
            @empty
            <div class="text-center py-6">
                <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-xs text-slate-400">No appointments scheduled for today.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Appointment Status Distribution --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-4">
        <div class="border-b border-[rgba(38,166,154,0.2)] pb-3 mb-4">
            <h2 class="text-sm font-bold text-slate-800">Appointment Status Distribution</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6 items-center">
            <div class="flex justify-center">
                <canvas id="statusChart" width="220" height="220"></canvas>
            </div>
            <div class="space-y-3">
                @foreach($statusBreakdown as $status => $total)
                @php $pct = $totalAppointments > 0 ? round(($total / $totalAppointments) * 100, 1) : 0; @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full {{ $statusDot[$status] ?? 'bg-slate-300' }} shrink-0"></span>
                        <span class="text-xs font-semibold text-slate-700">{{ $status }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-800">{{ $total }}</span>
                        <span class="text-xs text-slate-400">({{ $pct }}%)</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ======================== TAB: Completed ======================== --}}
<div id="tab-completed" class="tab-panel hidden">
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-4">
        <div class="border-b border-[rgba(38,166,154,0.2)] pb-3 mb-3">
            <h2 class="text-sm font-bold text-slate-800">Completed Appointments</h2>
            <p class="text-xs text-slate-400 mt-0.5">Recent appointments marked as completed</p>
        </div>
        <div class="space-y-2">
            @forelse($completedList as $apt)
            <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-slate-800">{{ $apt->client->full_name }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $apt->service_type ?? 'General' }} • {{ $apt->appointment_date->format('M d, Y') }} • {{ $apt->staff->name }}</p>
                    </div>
                </div>
                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Completed</span>
            </div>
            @empty
            <div class="text-center py-6">
                <p class="text-xs text-slate-400">No completed appointments yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ======================== TAB: Cancelled ======================== --}}
<div id="tab-cancelled" class="tab-panel hidden">
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-4">
        <div class="border-b border-[rgba(38,166,154,0.2)] pb-3 mb-3">
            <h2 class="text-sm font-bold text-slate-800">Cancelled Appointments</h2>
            <p class="text-xs text-slate-400 mt-0.5">Recent appointments that were cancelled</p>
        </div>
        <div class="space-y-2">
            @forelse($cancelledList as $apt)
            <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-slate-800">{{ $apt->client->full_name }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $apt->service_type ?? 'General' }} • {{ $apt->appointment_date->format('M d, Y') }} • {{ $apt->staff->name }}</p>
                    </div>
                </div>
                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-red-50 text-red-600 border border-red-200">Cancelled</span>
            </div>
            @empty
            <div class="text-center py-6">
                <p class="text-xs text-slate-400">No cancelled appointments recorded.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ======================== TAB: Staff Activity ======================== --}}
<div id="tab-staff" class="tab-panel hidden">
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-4">
        <div class="border-b border-[rgba(38,166,154,0.2)] pb-3 mb-3">
            <h2 class="text-sm font-bold text-slate-800">Staff Activity Summary</h2>
            <p class="text-xs text-slate-400 mt-0.5">Performance overview for all staff members</p>
        </div>
        <div class="space-y-2">
            @foreach($staffActivity as $staff)
            <div class="bg-slate-50 rounded-xl px-4 py-3">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#E8F5F3] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-[#26a69a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-slate-800">{{ $staff->name }}</p>
                            <p class="text-[10px] text-slate-400 uppercase font-semibold tracking-wide">{{ ucfirst($staff->role) }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4 pl-11">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                        <span class="text-xs text-slate-600">Assigned: <span class="font-bold text-slate-800">{{ $staff->assigned_appointments_count }}</span></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span class="text-xs text-slate-600">Completed: <span class="font-bold text-slate-800">{{ $staff->completed_appointments_count }}</span></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                        <span class="text-xs text-slate-600">Records: <span class="font-bold text-slate-800">{{ $staff->service_records_count }}</span></span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ======================== TAB: Client Visits ======================== --}}
<div id="tab-clients" class="tab-panel hidden">
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-4">
        <div class="border-b border-[rgba(38,166,154,0.2)] pb-3 mb-3">
            <h2 class="text-sm font-bold text-slate-800">Top Client Visits</h2>
            <p class="text-xs text-slate-400 mt-0.5">Clients ranked by total number of appointments</p>
        </div>
        <div class="space-y-2">
            @foreach($clientVisitSummary as $i => $client)
            <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-[#26a69a] flex items-center justify-center shrink-0">
                        <span class="text-[10px] font-bold text-white">{{ $i + 1 }}</span>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-slate-800">{{ $client->full_name }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Service records: {{ $client->service_records_count }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-[#26a69a]">{{ $client->appointments_count }}</p>
                    <p class="text-[10px] text-slate-400">visit{{ $client->appointments_count !== 1 ? 's' : '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Tab switching script --}}
<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
    document.querySelectorAll('.report-tab').forEach(b => {
        b.classList.remove('report-tab-active', 'bg-white', 'text-[#26a69a]', 'border-b-2', 'border-[#26a69a]');
        b.classList.add('text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');
    });
    document.getElementById('tab-' + tab).classList.remove('hidden');
    const active = document.querySelector('[data-tab="' + tab + '"]');
    active.classList.add('report-tab-active', 'bg-white', 'text-[#26a69a]', 'border-b-2', 'border-[#26a69a]');
    active.classList.remove('text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');
}
document.addEventListener('DOMContentLoaded', () => switchTab('daily'));
</script>

{{-- Status Doughnut Chart --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('statusChart');
    if (!ctx) return;
    const colors = {
        'Scheduled': '#f59e0b',
        'Confirmed': '#3b82f6',
        'Completed': '#10b981',
        'Cancelled': '#ef4444',
        'No Show':   '#94a3b8',
    };
    const data = @json($statusBreakdown);
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(data),
            datasets: [{
                data: Object.values(data),
                backgroundColor: Object.keys(data).map(k => colors[k] || '#cbd5e1'),
                borderWidth: 0,
                spacing: 2,
                borderRadius: 4,
            }]
        },
        options: {
            cutout: '65%',
            responsive: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endsection
