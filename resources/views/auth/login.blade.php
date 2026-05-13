@extends('layouts.guest')

@section('title', 'Sign In')

@section('content')
    <div class="w-full flex justify-center">
        <!-- Main Card Container -->
        <div
            class="flex flex-col md:flex-row w-full max-w-[1000px] bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[550px]">

            <!-- Left Side: Illustration -->
            <div class="hidden md:block w-1/2 bg-[#F5F5F5] relative">
                <!-- Using the existing vet login scene image -->
                <img src="{{ asset('assets/vet-login-scene.png') }}" alt="Veterinarian with a rabbit"
                    class="absolute inset-0 w-full h-full object-cover object-left">
            </div>

            <!-- Right Side: Login Form -->
            <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center bg-white relative overflow-hidden">

                    <div class="relative z-10 max-w-sm mx-auto w-full">
                        <!-- Logo -->
                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('assets/furmend-logo.png') }}" alt="FurMend Veterinary Clinic Logo"
                                class="h-32 w-auto drop-shadow-md">
                        </div>

                        <!-- Headings -->
                        <div class="text-center mb-8">
                            <h1 class="text-xl font-extrabold text-[#2C3E50] tracking-tight">Welcome Back</h1>
                            <p class="text-sm text-gray-500 mt-2">Please enter your details.</p>
                        </div>

                        @if ($errors->any())
                            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <!-- Form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-bold text-[#2C3E50] mb-1.5">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                    autocomplete="email" placeholder="Enter your email"
                                    class="w-full px-4 py-3 rounded-xl border border-[rgba(38,166,154,0.25)] bg-white text-[#2C3E50] text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#26A69A]/30 focus:border-[#26A69A] transition-all shadow-sm">
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password" class="block text-sm font-bold text-[#2C3E50] mb-1.5">Password</label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" required
                                        autocomplete="current-password" placeholder="Enter your password"
                                        class="w-full px-4 py-3 rounded-xl border border-[rgba(38,166,154,0.25)] bg-white text-[#2C3E50] text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#26A69A]/30 focus:border-[#26A69A] transition-all shadow-sm pr-12">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#26A69A]" onclick="togglePasswordVisibility(this)">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full py-3.5 px-4 bg-[#26A69A] hover:bg-[#1f8c82] text-white font-bold rounded-xl shadow-md shadow-[#26A69A]/20 transition-all transform hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm">
                                    Sign In
                                </button>
                            </div>

                            <!-- Forgot Password Link -->
                            <div class="text-center mt-6">
                                <a href="#"
                                    class="text-sm font-semibold text-[#26A69A] hover:text-[#1f8c82] hover:underline transition-colors">
                                    Forgot Password?
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
@endsection