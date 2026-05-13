@csrf

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="field-label" for="name">Full Name <span class="text-red-500">*</span></label>
        <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="field-input" placeholder="e.g., Dr. James Wilson">
    </div>

    <div>
        <label class="field-label" for="email">Email Address <span class="text-red-500">*</span></label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="field-input" placeholder="staff@furmend.com">
    </div>

    <div>
        <label class="field-label" for="role">Role <span class="text-red-500">*</span></label>
        <select id="role" name="role" class="field-select">
            @foreach ($roles as $role)
                <option value="{{ $role }}" @selected(old('role', $user->role ?? \App\Models\User::ROLE_STAFF) === $role)>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="field-label" for="specialization">Specialization</label>
        <input id="specialization" type="text" name="specialization" value="{{ old('specialization', $user->specialization ?? '') }}" class="field-input" placeholder="e.g., Surgery, General Practice">
    </div>

    <div>
        <label class="field-label" for="phone">Phone Number</label>
        <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="field-input" placeholder="(555) 123-4567">
    </div>

    <div>
        <label class="field-label" for="password">{{ isset($user) ? 'New Password' : 'Password' }} {!! isset($user) ? '' : '<span class="text-red-500">*</span>' !!}</label>
        <div class="relative">
            <input id="password" type="password" name="password" class="field-input pr-12" autocomplete="new-password">
            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#26A69A]" onclick="togglePasswordVisibility(this)">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>
        <p class="field-hint">{{ isset($user) ? 'Leave blank to keep current password.' : 'Minimum 8 characters.' }}</p>
    </div>

    <div class="md:col-span-2">
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
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button class="btn-primary" type="submit">{{ isset($user) ? 'Save Changes' : 'Create Staff Member' }}</button>
    <a href="{{ route('users.index') }}" class="btn-ghost">Back to Staff</a>
</div>

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
