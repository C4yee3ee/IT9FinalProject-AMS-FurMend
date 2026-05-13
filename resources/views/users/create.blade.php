@extends('layouts.app')

@section('title', 'Add User')

@section('content')
    <section class="flex flex-col gap-4">
        <span class="kicker">Admin Module</span>
        <div>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Create User Account</h1>
            <p class="mt-2 max-w-2xl text-xs text-slate-500">Add an administrator, receptionist, or staff member with the appropriate system role.</p>
        </div>
    </section>

    <section class="app-card px-6 py-6">
        <form method="POST" action="{{ route('users.store') }}">
            @include('users._form')
        </form>
    </section>
@endsection
