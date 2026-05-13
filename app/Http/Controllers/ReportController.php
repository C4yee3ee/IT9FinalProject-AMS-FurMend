<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\ServiceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $totalAppointments     = Appointment::count();
        $completedAppointments = Appointment::where('status', Appointment::STATUS_COMPLETED)->count();
        $totalClients          = Client::count();
        $totalServiceRecords   = ServiceRecord::count();

        $dailyAppointments = Appointment::whereDate('appointment_date', today())->count();
        $todaySchedule     = Appointment::with(['client', 'staff'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();

        $statusBreakdown = Appointment::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $completedList = Appointment::with(['client', 'staff'])
            ->where('status', Appointment::STATUS_COMPLETED)
            ->orderByDesc('appointment_date')
            ->limit(10)
            ->get();

        $cancelledList = Appointment::with(['client', 'staff'])
            ->where('status', Appointment::STATUS_CANCELLED)
            ->orderByDesc('appointment_date')
            ->limit(10)
            ->get();

        $staffActivity = User::whereIn('role', [User::ROLE_STAFF, User::ROLE_ADMIN])
            ->withCount([
                'assignedAppointments',
                'assignedAppointments as completed_appointments_count' => fn ($q) => $q->where('status', Appointment::STATUS_COMPLETED),
                'serviceRecords',
            ])
            ->orderBy('first_name')
            ->get();

        $clientVisitSummary = Client::withCount(['appointments', 'serviceRecords'])
            ->orderByDesc('appointments_count')
            ->limit(10)
            ->get();

        return view('reports.index', compact(
            'totalAppointments',
            'completedAppointments',
            'totalClients',
            'totalServiceRecords',
            'dailyAppointments',
            'todaySchedule',
            'statusBreakdown',
            'completedList',
            'cancelledList',
            'staffActivity',
            'clientVisitSummary'
        ));
    }

    public function export(Request $request): Response
    {
        $type      = $request->input('type', 'appointments');
        $dateFrom  = $request->input('date_from');
        $dateTo    = $request->input('date_to');
        $timestamp = now()->format('Y-m-d');

        return match ($type) {
            'clients' => $this->exportClients($timestamp),
            'staff'   => $this->exportStaff($timestamp),
            default   => $this->exportAppointments($timestamp, $dateFrom, $dateTo),
        };
    }

    // ── Private helpers ──────────────────────────────────────────────────────────

    private function exportAppointments(string $timestamp, ?string $from, ?string $to): Response
    {
        $rows = Appointment::with(['client', 'staff', 'creator'])
            ->when($from, fn ($q) => $q->whereDate('appointment_date', '>=', $from))
            ->when($to,   fn ($q) => $q->whereDate('appointment_date', '<=', $to))
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $header = ['ID', 'Client Name', 'Client Phone', 'Staff', 'Service Type', 'Date', 'Time', 'Status', 'Notes', 'Created By', 'Created At'];

        $lines = [$header];
        foreach ($rows as $apt) {
            $lines[] = [
                $apt->id,
                $apt->client->full_name ?? '',
                $apt->client->phone     ?? '',
                $apt->staff->name       ?? '',
                $apt->service_type      ?? '',
                $apt->appointment_date->format('Y-m-d'),
                $apt->formatted_time    ?? '',
                $apt->status,
                $apt->notes             ?? '',
                $apt->creator->name     ?? '',
                $apt->created_at->format('Y-m-d H:i'),
            ];
        }

        return $this->streamCsv($lines, "appointments_{$timestamp}.csv");
    }

    private function exportClients(string $timestamp): Response
    {
        $rows = Client::withCount(['appointments', 'serviceRecords'])
            ->orderBy('first_name')
            ->get();

        $header = ['ID', 'First Name', 'Last Name', 'Email', 'Phone', 'Address', 'Pet Name', 'Pet Species', 'Pet Breed', 'Total Appointments', 'Service Records', 'Registered On'];

        $lines = [$header];
        foreach ($rows as $c) {
            $lines[] = [
                $c->id,
                $c->first_name,
                $c->last_name,
                $c->email       ?? '',
                $c->phone       ?? '',
                $c->address     ?? '',
                $c->pet_name    ?? '',
                $c->pet_species ?? '',
                $c->pet_breed   ?? '',
                $c->appointments_count,
                $c->service_records_count,
                $c->created_at->format('Y-m-d'),
            ];
        }

        return $this->streamCsv($lines, "clients_{$timestamp}.csv");
    }

    private function exportStaff(string $timestamp): Response
    {
        $rows = User::withCount([
            'assignedAppointments',
            'assignedAppointments as completed_appointments_count' => fn ($q) => $q->where('status', Appointment::STATUS_COMPLETED),
            'serviceRecords',
        ])->orderBy('first_name')->get();

        $header = ['ID', 'Name', 'Email', 'Role', 'Specialization', 'Active', 'Assigned Appointments', 'Completed Appointments', 'Service Records', 'Joined'];

        $lines = [$header];
        foreach ($rows as $u) {
            $lines[] = [
                $u->id,
                $u->name,
                $u->email,
                ucfirst($u->role),
                $u->specialization ?? '',
                $u->is_active ? 'Yes' : 'No',
                $u->assigned_appointments_count,
                $u->completed_appointments_count,
                $u->service_records_count,
                $u->created_at->format('Y-m-d'),
            ];
        }

        return $this->streamCsv($lines, "staff_{$timestamp}.csv");
    }

    private function streamCsv(array $rows, string $filename): Response
    {
        $output = fopen('php://temp', 'r+');
        fwrite($output, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel compatibility

        foreach ($rows as $row) {
            fputcsv($output, $row);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }
}
