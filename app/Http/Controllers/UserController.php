<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $role   = $request->string('role')->toString();

        $users = User::query()
            ->withCount(['assignedAppointments', 'serviceRecords'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', "%{$search}%")
                             ->orWhere('last_name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, fn ($query) => $query->where('role', $role))
            ->orderBy('first_name')
            ->paginate(10)
            ->withQueryString();

        $roleStats = [
            'total'        => User::count(),
            'admin'        => User::where('role', 'admin')->count(),
            'staff'        => User::where('role', 'staff')->count(),
            'receptionist' => User::where('role', 'receptionist')->count(),
        ];

        return view('users.index', [
            'users'        => $users,
            'roles'        => User::roles(),
            'search'       => $search,
            'selectedRole' => $role,
            'roleStats'    => $roleStats,
        ]);
    }

    public function create(): View
    {
        return view('users.create', ['roles' => User::roles()]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        return redirect()->route('users.index')
            ->with('success', 'Staff member created successfully.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user'  => $user,
            'roles' => User::roles(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (($data['role'] ?? $user->role) !== User::ROLE_ADMIN && $user->isAdmin() && User::where('role', User::ROLE_ADMIN)->count() === 1) {
            return back()->withErrors([
                'role' => 'At least one administrator account must remain active.',
            ])->withInput();
        }

        if (! filled($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function toggleActive(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'You cannot change your own status.']);
        }

        $user->update(['is_active' => (bool) $request->input('set_active', ! $user->is_active)]);

        return back()->with('success', 'Staff status updated.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->withErrors([
                'user' => 'You cannot delete the account you are currently signed in with.',
            ]);
        }

        if ($user->isAdmin() && User::where('role', User::ROLE_ADMIN)->count() === 1) {
            return back()->withErrors([
                'user' => 'The last administrator account cannot be deleted.',
            ]);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Staff member removed successfully.');
    }
}
