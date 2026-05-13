@extends('layouts.app')

@section('title', 'Add Client')

@section('content')
    <section class="flex flex-col gap-4">
        <span class="kicker">Client Intake</span>
        <div>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Add a New Client</h1>
            <p class="mt-2 max-w-2xl text-xs text-slate-500">Create a complete client profile before scheduling appointments or recording service history.</p>
        </div>
    </section>

    <section class="app-card px-6 py-6">
        <form method="POST" action="{{ route('clients.store') }}">
            @include('clients._form')
        </form>
    </section>
@endsection
