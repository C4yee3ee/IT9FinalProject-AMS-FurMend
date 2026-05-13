<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trim($__env->yieldContent('title')) ? trim($__env->yieldContent('title')).' | ' : '' }}{{ $appSettings['system_name'] ?? 'FurMend Appointment System' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased relative min-h-screen flex items-center justify-center p-4" style="background: #26A69A;">



    <main class="relative z-10 w-full max-w-5xl">
        @yield('content')
    </main>
    @include('partials.toast')
</body>
</html>
