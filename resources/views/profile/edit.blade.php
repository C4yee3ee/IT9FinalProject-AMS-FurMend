@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <section class="flex flex-col gap-4">
        <span class="kicker">Profile Management</span>
        <div>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Your Profile</h1>
            <p class="mt-2 max-w-2xl text-xs text-slate-500">Update your account details and maintain your own sign-in credentials.</p>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-2">
        <article class="app-card px-6 py-6">
            <h2 class="text-xl font-bold text-slate-900">Profile Details</h2>
            <form method="POST" action="{{ route('profile.update') }}" class="mt-6 grid gap-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="field-label" for="name">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="field-input">
                </div>

                <div>
                    <label class="field-label" for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="field-input">
                </div>

                <div class="rounded-2xl bg-slate-50 px-4 py-4 text-sm text-slate-600">
                    <p class="font-semibold text-slate-900">Current Role</p>
                    <p class="mt-2">{{ ucfirst($user->role) }}</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button class="btn-primary" type="submit">Save Profile</button>
                </div>
            </form>
        </article>

        <article class="app-card px-6 py-6">
            <h2 class="text-xl font-bold text-slate-900">Update Password</h2>
            <form method="POST" action="{{ route('profile.password') }}" class="mt-6 grid gap-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="field-label" for="current_password">Current Password</label>
                    <div class="relative">
                        <input id="current_password" type="password" name="current_password" class="field-input pr-12" autocomplete="current-password">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#26A69A]" onclick="togglePasswordVisibility(this)">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="field-label" for="password">New Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" class="field-input pr-12" autocomplete="new-password">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#26A69A]" onclick="togglePasswordVisibility(this)">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="field-label" for="password_confirmation">Confirm Password</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" class="field-input pr-12" autocomplete="new-password">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#26A69A]" onclick="togglePasswordVisibility(this)">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button class="btn-secondary" type="submit">Update Password</button>
                </div>
            </form>
        </article>
    </section>
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
    </script>
@endsection
