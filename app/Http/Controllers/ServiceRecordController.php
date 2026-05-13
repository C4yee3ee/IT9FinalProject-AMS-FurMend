<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRecordRequest;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\ServiceRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRecordController extends Controller
{
    public function index(Request $request): View
    {
        $user   = $request->user();
        $search = $request->string('search')->toString();

        $serviceRecords = ServiceRecord::with(['appointment', 'client', 'staff'])
            ->when($user->isStaff(), fn ($query) => $query->where('staff_id', $user->id))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                      ->orWhere('remarks', 'like', "%{$search}%")
                      ->orWhereHas('client', fn ($cq) => $cq->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"))
                      ->orWhereHas('staff', fn ($sq) => $sq->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalRecords  = ServiceRecord::count();
        $thisMonth     = ServiceRecord::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $activeClients = Client::has('serviceRecords')->count();

        // Completed appointments without a service record (for the create modal)
        $availableAppointments = [];
        if (! $user->isReceptionist()) {
            $availableAppointments = Appointment::with(['client', 'staff'])
                ->where('status', Appointment::STATUS_COMPLETED)
                ->doesntHave('serviceRecord')
                ->when($user->isStaff(), fn ($query) => $query->where('staff_id', $user->id))
                ->orderByDesc('appointment_date')
                ->orderByDesc('appointment_time')
                ->get();
        }

        return view('service-records.index', [
            'serviceRecords'        => $serviceRecords,
            'search'                => $search,
            'totalRecords'          => $totalRecords,
            'thisMonth'             => $thisMonth,
            'activeClients'         => $activeClients,
            'canCreateServiceRecord' => ! $user->isReceptionist(),
            'availableAppointments' => $availableAppointments,
        ]);
    }

    public function create(Request $request): View
    {
        $user = $request->user();

        return view('service-records.create', [
            'appointments' => Appointment::with(['client', 'staff'])
                ->where('status', Appointment::STATUS_COMPLETED)
                ->doesntHave('serviceRecord')
                ->when($user->isStaff(), fn ($query) => $query->where('staff_id', $user->id))
                ->orderByDesc('appointment_date')
                ->orderByDesc('appointment_time')
                ->get(),
        ]);
    }

    public function store(StoreServiceRecordRequest $request): RedirectResponse
    {
        $appointment = Appointment::with(['client', 'staff', 'serviceRecord'])->findOrFail($request->validated('appointment_id'));

        if ($appointment->status !== Appointment::STATUS_COMPLETED) {
            return back()->withErrors([
                'appointment_id' => 'Service records can only be created for completed appointments.',
            ])->withInput();
        }

        if ($appointment->serviceRecord) {
            return back()->withErrors([
                'appointment_id' => 'A service record already exists for the selected appointment.',
            ])->withInput();
        }

        if ($request->user()->isStaff() && $appointment->staff_id !== $request->user()->id) {
            abort(403, 'You may only log service notes for your assigned appointments.');
        }

        $record = ServiceRecord::create([
            'appointment_id' => $appointment->id,
            'client_id'      => $appointment->client_id,
            'staff_id'       => $appointment->staff_id,
            'description'    => $request->validated('description'),
            'service_date'   => $request->validated('service_date'),
            'remarks'        => $request->validated('remarks'),
        ]);

        return redirect()->route('service-records.index')
            ->with('success', "Service record #{$record->id} created successfully.");
    }
}
