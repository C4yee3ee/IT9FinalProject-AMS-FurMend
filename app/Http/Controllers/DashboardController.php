<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\ServiceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user  = $request->user();
        $today = today()->toDateString();

        $appointmentScope   = Appointment::with(['client', 'staff', 'creator']);
        $serviceRecordScope = ServiceRecord::with(['client', 'staff', 'appointment']);

        if ($user->isStaff()) {
            $appointmentScope->where('staff_id', $user->id);
            $serviceRecordScope->where('staff_id', $user->id);
        }

        $recentAppointments = (clone $appointmentScope)
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->limit(5)
            ->get();

        $recentServiceRecords = (clone $serviceRecordScope)
            ->orderByDesc('service_date')
            ->limit(4)
            ->get();

        // ── Stat cards ────────────────────────────────────────────────────────
        if ($user->isAdmin()) {
            $heroTitle = 'System operations at a glance';
            $heroCopy  = 'Monitor bookings, client records, staff activity, and configuration from one dashboard.';
            $statCards = [
                ['label' => 'Total clients',           'value' => Client::count()],
                ['label' => 'Appointments today',      'value' => Appointment::whereDate('appointment_date', $today)->count()],
                ['label' => 'Completed appointments',  'value' => Appointment::where('status', Appointment::STATUS_COMPLETED)->count()],
                ['label' => 'Service records',         'value' => ServiceRecord::count()],
            ];
        } elseif ($user->isReceptionist()) {
            $heroTitle = 'Front desk schedule board';
            $heroCopy  = 'Track active bookings, manage client updates, and keep the appointment queue moving smoothly.';
            $statCards = [
                ['label' => 'Registered clients',    'value' => Client::count()],
                ['label' => 'Bookings today',         'value' => Appointment::whereDate('appointment_date', $today)->count()],
                ['label' => 'Upcoming this week',     'value' => Appointment::whereBetween('appointment_date', [$today, today()->addDays(7)->toDateString()])->count()],
                ['label' => 'Created by you',         'value' => Appointment::where('created_by', $user->id)->count()],
            ];
        } else {
            $heroTitle = 'Your personal care schedule';
            $heroCopy  = 'See your assigned appointments, completed visits, and the latest service history tied to your work.';
            $statCards = [
                ['label' => 'Assigned today',      'value' => Appointment::where('staff_id', $user->id)->whereDate('appointment_date', $today)->count()],
                ['label' => 'Upcoming assigned',   'value' => Appointment::where('staff_id', $user->id)->whereDate('appointment_date', '>=', $today)->count()],
                ['label' => 'Completed by you',    'value' => Appointment::where('staff_id', $user->id)->where('status', Appointment::STATUS_COMPLETED)->count()],
                ['label' => 'Service notes logged','value' => ServiceRecord::where('staff_id', $user->id)->count()],
            ];
        }

        // ── Weekly bar chart ──────────────────────────────────────────────────
        $startOfWeek = now()->startOfWeek();
        $endOfWeek   = now()->endOfWeek();

        $weeklyQuery = (clone $appointmentScope)
            ->whereBetween('appointment_date', [$startOfWeek, $endOfWeek])
            ->get();

        $weeklyAppointmentsData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $weeklyAppointmentsData[] = $weeklyQuery->filter(fn ($a) => $a->appointment_date->isSameDay($date))->count();
        }

        // ── Monthly trend (last 6 months) ─────────────────────────────────────
        $monthlyLabels = [];
        $monthlyData   = [];
        for ($m = 5; $m >= 0; $m--) {
            $month = now()->subMonths($m);
            $monthlyLabels[] = $month->format('M');
            $monthlyData[]   = (clone $appointmentScope)
                ->whereYear('appointment_date', $month->year)
                ->whereMonth('appointment_date', $month->month)
                ->count();
        }

        // ── Status breakdown (doughnut) ───────────────────────────────────────
        $allAppointments = (clone $appointmentScope)->get();
        $statusBreakdown = $allAppointments->groupBy('status')->map->count();

        // ── Appointment Types (bar data) ──────────────────────────────────────
        /** @var \Illuminate\Support\Collection $typeDistribution */
        $typeDistribution = $allAppointments->groupBy(fn ($a) => strtolower($a->service_type))->map->count();

        /** @var int $totalAppointments */
        $totalAppointments = $typeDistribution->sum();

        $typeColors = [
            ['color' => 'bg-[#41B8A3]', 'text' => 'text-[#41B8A3]', 'hex' => '#41B8A3'],
            ['color' => 'bg-[#FF8A65]', 'text' => 'text-[#FF8A65]', 'hex' => '#FF8A65'],
            ['color' => 'bg-[#9C27B0]', 'text' => 'text-[#9C27B0]', 'hex' => '#9C27B0'],
            ['color' => 'bg-[#26A69A]', 'text' => 'text-[#26A69A]', 'hex' => '#26A69A'],
            ['color' => 'bg-[#3b82f6]', 'text' => 'text-[#3b82f6]', 'hex' => '#3b82f6'],
            ['color' => 'bg-[#f59e0b]', 'text' => 'text-[#f59e0b]', 'hex' => '#f59e0b'],
        ];

        $appointmentTypesData = [];
        $colorIndex = 0;
        /** @var \Illuminate\Support\Collection $sortedDistribution */
        $sortedDistribution = $typeDistribution->sortDesc();
        foreach ($sortedDistribution as $type => $count) {
            $pct = $totalAppointments > 0 ? round(($count / $totalAppointments) * 100) : 0;
            $c   = $typeColors[$colorIndex % count($typeColors)];
            $appointmentTypesData[] = [
                'label' => ucfirst($type),
                'count' => $count,
                'pct'   => $pct . '%',
                'color' => $c['color'],
                'text'  => $c['text'],
                'hex'   => $c['hex'],
            ];
            $colorIndex++;
        }

        // ── Top staff by completed appointments ───────────────────────────────
        $topStaff = User::whereIn('role', [User::ROLE_STAFF, User::ROLE_ADMIN])
            ->withCount([
                'assignedAppointments',
                'assignedAppointments as completed_count' => fn ($q) => $q->where('status', Appointment::STATUS_COMPLETED),
            ])
            ->orderByDesc('completed_count')
            ->limit(5)
            ->get();

        // ── New clients this month ────────────────────────────────────────────
        $newClientsThisMonth = Client::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('dashboard.index', [
            'heroTitle'              => $heroTitle,
            'heroCopy'               => $heroCopy,
            'statCards'              => $statCards,
            'recentAppointments'     => $recentAppointments,
            'recentServiceRecords'   => $recentServiceRecords,
            'weeklyAppointmentsData' => $weeklyAppointmentsData,
            'appointmentTypesData'   => $appointmentTypesData,
            'monthlyLabels'          => $monthlyLabels,
            'monthlyData'            => $monthlyData,
            'statusBreakdown'        => $statusBreakdown,
            'topStaff'               => $topStaff,
            'newClientsThisMonth'    => $newClientsThisMonth,
            'totalAppointments'      => $totalAppointments,
        ]);
    }
}
