@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')
    <section class="flex flex-col gap-4">
        <span class="kicker">Client Management</span>
        <div>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Edit Client Profile</h1>
            <p class="mt-2 max-w-2xl text-xs text-slate-500">Update contact details, notes, and supporting information for {{ $client->full_name }}.</p>
        </div>
    </section>

    <section class="app-card px-6 py-6">
        <form method="POST" action="{{ route('clients.update', $client) }}">
            @method('PUT')
            @include('clients._form')
        </form>
    </section>
@endsection
