<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentStatusRequest;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $status = $request->string('status')->toString();
        $search = $request->string('search')->toString();

        $baseQuery = Appointment::when($user->isStaff(), fn ($query) => $query->where('staff_id', $user->id));

        $totalAppointments = (clone $baseQuery)->count();
        $todayAppointments = (clone $baseQuery)->whereDate('appointment_date', today())->count();
        $scheduledAppointments = (clone $baseQuery)->where('status', Appointment::STATUS_SCHEDULED)->count();
        $completedAppointments = (clone $baseQuery)->where('status', Appointment::STATUS_COMPLETED)->count();

        // Clinic-friendly ordering:
        // 1. Today's appointments first (sorted by time ASC)
        // 2. Future appointments next (sorted by date ASC, time ASC)
        // 3. Past appointments last (sorted by date DESC — most recent past first)
        $appointments = (clone $baseQuery)->with(['client', 'staff', 'creator'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('service_type', 'like', "%{$search}%")
                        ->orWhereHas('client', function ($clientQuery) use ($search) {
                            $clientQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderByRaw('CASE WHEN appointment_date >= CURDATE() THEN 0 ELSE 1 END ASC')
            ->orderByRaw('CASE WHEN appointment_date >= CURDATE() THEN appointment_date END ASC')
            ->orderBy('appointment_time', 'asc')
            ->orderByRaw('CASE WHEN appointment_date < CURDATE() THEN appointment_date END DESC')
            ->paginate(10)
            ->withQueryString();

        return view('appointments.index', [
            'appointments' => $appointments,
            'statuses' => Appointment::STATUSES,
            'selectedStatus' => $status,
            'search' => $search,
            'canManageAppointments' => ! $user->isStaff(),
            'totalAppointments' => $totalAppointments,
            'todayAppointments' => $todayAppointments,
            'scheduledAppointments' => $scheduledAppointments,
            'completedAppointments' => $completedAppointments,
        ]);
    }

    public function create(): View
    {
        return view('appointments.create', [
            'clients' => Client::orderBy('first_name')->get(),
            'staffMembers' => User::where('role', User::ROLE_STAFF)->orderBy('first_name')->get(),
            'statuses' => Appointment::STATUSES,
        ]);
    }

    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $appointment = Appointment::create([
            ...$request->validated(),
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment): View
    {
        $this->authorizeAppointmentAccess(request()->user(), $appointment);
        $appointment->load(['client', 'staff', 'creator', 'serviceRecord']);

        return view('appointments.show', [
            'appointment' => $appointment,
            'canManageAppointment' => ! request()->user()->isStaff(),
        ]);
    }

    public function edit(Appointment $appointment): View
    {
        abort_if($appointment->status === Appointment::STATUS_COMPLETED, 422, 'Completed appointments cannot be edited unless reopened.');

        return view('appointments.edit', [
            'appointment' => $appointment,
            'clients' => Client::orderBy('first_name')->get(),
            'staffMembers' => User::where('role', User::ROLE_STAFF)->orderBy('first_name')->get(),
            'statuses' => Appointment::STATUSES,
        ]);
    }

    public function update(StoreAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        abort_if($appointment->status === Appointment::STATUS_COMPLETED, 422, 'Completed appointments cannot be edited unless reopened.');

        $appointment->update($request->validated());

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    public function updateStatus(UpdateAppointmentStatusRequest $request, Appointment $appointment): RedirectResponse
    {
        $this->authorizeAppointmentAccess($request->user(), $appointment);

        $validated = $request->validated();

        if ($appointment->serviceRecord && $appointment->status === Appointment::STATUS_COMPLETED && $validated['status'] !== Appointment::STATUS_COMPLETED) {
            return back()->withErrors([
                'status' => 'Appointments with a saved service record cannot be reopened until the record is reviewed by an administrator.',
            ]);
        }

        $appointment->update($validated);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment status updated successfully.');
    }

    private function authorizeAppointmentAccess(User $user, Appointment $appointment): void
    {
        if ($user->isStaff() && $appointment->staff_id !== $user->id) {
            abort(403, 'You may only access appointments assigned to you.');
        }
    }
}
