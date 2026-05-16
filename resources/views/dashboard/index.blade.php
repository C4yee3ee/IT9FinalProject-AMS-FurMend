@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- ── Hero ── --}}
<div class="rounded-2xl px-6 py-5 text-white shadow-md mb-5"
    style="background:linear-gradient(135deg,#26A69A 0%,#4DB6AC 60%,#80CBC4 100%)">
    <div class="flex items-center justify-between">
        <div>
            @php
            $hour = now()->format('H');
            $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening' );
                @endphp
                {{-- Page header: text-xl (20px) --}}
                <h1 class="text-xl font-bold mb-1">{{ $greeting }}, {{ auth()->user()->first_name }}!</h1>
                {{-- Labels: text-xs (12px) --}}
                <p class="text-xs text-white/80">{{ $heroCopy }}</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-14 h-14 text-white/15">
            <circle cx="11" cy="4" r="2" />
            <circle cx="18" cy="8" r="2" />
            <circle cx="20" cy="16" r="2" />
            <path d="M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z" />
        </svg>
    </div>
</div>

{{-- ── KPI Cards ── --}}
@php
$statStyle = [
['accent'=>'#26A69A','iconBg'=>'#E8F5F3','iconColor'=>'#26A69A',
'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
['accent'=>'#2C3E50','iconBg'=>'#EEF2F7','iconColor'=>'#2C3E50',
'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
['accent'=>'#10b981','iconBg'=>'#D1FAE5','iconColor'=>'#10b981',
'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
['accent'=>'#FF8A65','iconBg'=>'#FFF3E0','iconColor'=>'#FF8A65',
'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
];
@endphp
<div class="grid grid-cols-4 gap-4 mb-5">
    @foreach ($statCards as $i => $card)
    @php $s = $statStyle[$i % 4]; @endphp
    <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] px-4 py-3 hover:shadow-md transition-shadow"
        style="border-top:3px solid {{ $s['accent'] }}">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-medium text-slate-500">{{ $card['label'] }}</span>
            <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:{{ $s['iconBg'] }}">
                <svg class="w-4 h-4" fill="none" stroke="{{ $s['iconColor'] }}" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}" />
                </svg>
            </div>
        </div>
        <p class="text-lg font-extrabold text-slate-800">{{ $card['value'] }}</p>
    </div>
    @endforeach
</div>

{{-- ── 2-column layout ── --}}
<div class="grid gap-4" style="grid-template-columns:1fr 300px;align-items:start">

    {{-- LEFT --}}
    <div class="space-y-4">

        {{-- Charts --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-5">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        {{-- Card titles: text-sm (14px) --}}
                        <h2 class="text-sm font-bold text-slate-800">Weekly Appointments</h2>
                        {{-- Labels: text-xs (12px) --}}
                        <p class="text-xs text-slate-400 mt-0.5">{{ now()->startOfWeek()->format('M d') }} – {{ now()->endOfWeek()->format('M d') }}</p>
                    </div>
                    <span class="text-xs font-semibold text-[#26A69A] bg-[#E8F5F3] px-2.5 py-0.5 rounded-md">
                        {{ array_sum($weeklyAppointmentsData) }} total
                    </span>
                </div>
                <div style="height:155px;position:relative">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-5">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">Monthly Overview</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Last 6 months</p>
                    </div>
                    <span class="text-xs font-semibold text-[#26A69A] bg-[#E8F5F3] px-2.5 py-0.5 rounded-md">
                        {{ now()->format('Y') }}
                    </span>
                </div>
                <div style="height:155px;position:relative">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Status pills definition (same as appointments/index.blade.php) --}}
        @php
        $statusBadge = [
        'Scheduled' => 'bg-amber-50 text-amber-700 border border-amber-200',
        'scheduled' => 'bg-amber-50 text-amber-700 border border-amber-200',
        'Confirmed' => 'bg-blue-50 text-blue-700 border border-blue-200',
        'confirmed' => 'bg-blue-50 text-blue-700 border border-blue-200',
        'Completed' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        'completed' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        'Cancelled' => 'bg-red-50 text-red-600 border border-red-200',
        'cancelled' => 'bg-red-50 text-red-600 border border-red-200',
        'No Show' => 'bg-slate-100 text-slate-600 border border-slate-200',
        'no show' => 'bg-slate-100 text-slate-600 border border-slate-200',
        'no-show' => 'bg-slate-100 text-slate-600 border border-slate-200',
        ];
        @endphp

        {{-- Recent Activity --}}
        <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] overflow-hidden">
            <div class="px-5 py-4 border-b border-[rgba(38,166,154,0.2)] flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-slate-100 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">Recent Appointment Activity</h2>
                        <p class="text-xs text-slate-400">Latest {{ $recentAppointments->count() }} appointments</p>
                    </div>
                </div>
                <a href="{{ route('appointments.index') }}"
                    class="text-xs font-semibold text-[#26A69A] hover:text-[#1f8c82] flex items-center gap-1 transition-colors">
                    View all
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div>
                @forelse($recentAppointments as $apt)
                @php $pill = $statusBadge[strtolower($apt->status)] ?? 'bg-slate-100 text-slate-600 border border-slate-200'; @endphp
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-full bg-[#E8F5F3] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-[#26A69A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="{{ strtolower($apt->status)==='completed' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'}}" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            {{-- Body text: text-sm (14px) --}}
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $apt->client->full_name }}</p>
                            {{-- Small info: text-xs (12px) --}}
                            <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $apt->staff->name }} &middot; {{ $apt->appointment_date->format('M d, Y') }} at {{ $apt->formatted_time }}</p>
                        </div>
                    </div>
                    {{-- Status pill — identical to appointments/index.blade.php --}}
                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold shrink-0 ml-3 {{ $pill }}">
                        {{ ucfirst($apt->status) }}
                    </span>
                </div>
                @empty
                <div class="px-5 py-10 text-center text-sm text-slate-400">No recent appointments.</div>
                @endforelse
            </div>
        </div>

        {{-- Service Notes --}}
        <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] overflow-hidden">
            <div class="px-5 py-4 border-b border-[rgba(38,166,154,0.2)] flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-slate-100 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">Recent Service Notes</h2>
                        <p class="text-xs text-slate-400">Latest records logged</p>
                    </div>
                </div>
                <a href="{{ route('service-records.index') }}"
                    class="text-xs font-semibold text-[#26A69A] hover:text-[#1f8c82] flex items-center gap-1 transition-colors">
                    View all
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2">
                @forelse($recentServiceRecords as $record)
                <div class="p-5 border-b border-r border-slate-50 hover:bg-slate-50/50 transition-colors last:border-b-0">
                    <div class="flex items-start justify-between gap-2 mb-1.5">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $record->client->full_name }}</p>
                        <span class="text-xs font-bold text-[#26A69A] shrink-0 bg-[#E8F5F3] px-2 py-0.5 rounded">#{{ $record->id }}</span>
                    </div>
                    <p class="text-xs text-slate-400 mb-2">{{ $record->service_date->format('M d, Y') }} &middot; {{ $record->staff->name }}</p>
                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">{{ $record->description }}</p>
                </div>
                @empty
                <div class="col-span-2 px-5 py-10 text-center text-sm text-slate-400">No service notes yet.</div>
                @endforelse
            </div>
        </div>

    </div>{{-- end left --}}

    {{-- RIGHT sidebar --}}
    <div class="space-y-4">

        {{-- Status Breakdown --}}
        <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-5">
            <h2 class="text-sm font-bold text-slate-800 mb-4">Status Breakdown</h2>
            <div class="flex justify-center mb-4">
                <canvas id="statusChart" width="150" height="150"></canvas>
            </div>
            @php $statusHex=['Scheduled'=>'#F59E0B','Confirmed'=>'#3B82F6','Completed'=>'#10B981','Cancelled'=>'#EF4444','No Show'=>'#94A3B8']; @endphp
            <div class="space-y-3">
                @foreach($statusBreakdown as $status => $count)
                @php $hex=$statusHex[$status]??'#94a3b8'; $pct=$totalAppointments>0?round($count/$totalAppointments*100):0; @endphp
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background:{{ $hex }}"></span>
                            {{-- Body text: text-sm (14px) --}}
                            <span class="text-sm text-slate-600">{{ $status }}</span>
                        </div>
                        <span class="text-xs font-bold text-slate-700">{{ $count }} <span class="font-normal text-slate-400">({{ $pct }}%)</span></span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full ml-4" style="height:5px">
                        <div class="rounded-full" style="height:5px;width:{{ $pct }}%;background:{{ $hex }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Appointment Types --}}
        <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-5">
            <h2 class="text-sm font-bold text-slate-800 mb-4">Appointment Types</h2>
            <div class="space-y-3">
                @forelse($appointmentTypesData as $type)
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-sm text-slate-600">{{ $type['label'] }}</span>
                        <span class="text-xs font-bold {{ $type['text'] }}">{{ $type['pct'] }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full overflow-hidden" style="height:6px">
                        <div class="{{ $type['color'] }} rounded-full" style="height:6px;width:{{ $type['pct'] }};min-width:6px"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">{{ $type['count'] }} appointments</p>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">No data yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Top Staff --}}
        <div class="bg-white rounded-2xl shadow-sm border border-[rgba(38,166,154,0.2)] p-5">
            <h2 class="text-sm font-bold text-slate-800 mb-4">Top Staff by Completions</h2>
            <div class="space-y-4">
                @forelse($topStaff as $i => $member)
                @php
                $medal = match($i){ 0=>'🥇', 1=>'🥈', 2=>'🥉', default=>'' };
                $barMax = $topStaff->first()->assigned_appointments_count ?: 1;
                $barW = $barMax > 0 ? round($member->assigned_appointments_count / $barMax * 100) : 0;
                @endphp
                <div class="flex items-center gap-3">
                    <span class="text-base w-5 text-center shrink-0">{{ $medal ?: ($i+1).'.' }}</span>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-1">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $member->name }}</p>
                            <span class="text-xs font-bold text-[#26A69A] shrink-0 ml-2">{{ $member->completed_count }} done</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full" style="height:5px">
                            <div class="rounded-full" style="height:5px;width:{{ $barW }}%;background:#41B8A3"></div>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">{{ ucfirst($member->role) }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">No staff data yet.</p>
                @endforelse
            </div>
        </div>

    </div>{{-- end right --}}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barLabels = {
            id: 'barLabels',
            afterDatasetsDraw(chart) {
                const {
                    ctx,
                    data
                } = chart;
                ctx.save();
                ctx.font = '600 11px Inter, system-ui, sans-serif';
                ctx.fillStyle = '#64748b';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';
                chart.getDatasetMeta(0).data.forEach((bar, i) => {
                    const v = data.datasets[0].data[i];
                    if (v > 0) ctx.fillText(v, bar.x, bar.y - 4);
                });
                ctx.restore();
            }
        };

        new Chart(document.getElementById('weeklyChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: @json($weeklyAppointmentsData),
                    backgroundColor: 'rgba(38,166,154,0.8)',
                    hoverBackgroundColor: '#26A69A',
                    borderRadius: {
                        topLeft: 6,
                        topRight: 6
                    },
                    maxBarThickness: 36,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 20
                    }
                },
                scales: {
                    y: {
                        display: false,
                        beginAtZero: true
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#94A3B8',
                            font: {
                                size: 12,
                                family: 'Inter, system-ui, sans-serif',
                                weight: '600'
                            },
                            padding: 6
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            },
            plugins: [barLabels]
        });

        new Chart(document.getElementById('monthlyChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    data: @json($monthlyData),
                    borderColor: '#26A69A',
                    backgroundColor: 'rgba(38,166,154,0.07)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#26A69A',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.04)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94A3B8',
                            font: {
                                size: 11,
                                family: 'Inter, system-ui, sans-serif'
                            },
                            maxTicksLimit: 5
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94A3B8',
                            font: {
                                size: 12,
                                weight: '600',
                                family: 'Inter, system-ui, sans-serif'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });

        const sd = @json($statusBreakdown);
        const sc = {
            'Scheduled': '#F59E0B',
            'Confirmed': '#3B82F6',
            'Completed': '#10B981',
            'Cancelled': '#EF4444',
            'No Show': '#94A3B8'
        };
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(sd),
                datasets: [{
                    data: Object.values(sd),
                    backgroundColor: Object.keys(sd).map(k => sc[k] || '#CBD5E1'),
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    spacing: 2,
                    borderRadius: 4,
                }]
            },
            options: {
                cutout: '68%',
                responsive: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index'
                    }
                }
            }
        });
    });
</script>
@endpush