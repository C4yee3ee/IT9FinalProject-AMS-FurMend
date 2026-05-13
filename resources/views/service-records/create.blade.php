@extends('layouts.app')

@section('title', 'Add Service Record')

@section('content')
    <section class="flex flex-col gap-4">
        <span class="kicker">Service Record Module</span>
        <div>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Create Service Record</h1>
            <p class="mt-2 max-w-2xl text-xs text-slate-500">Capture the completed care summary and remarks for an appointment that has already been marked as completed.</p>
        </div>
    </section>

    <section class="app-card px-6 py-6">
        @if ($appointments->isEmpty())
            <div class="empty-state">
                There are no completed appointments waiting for a service record.
            </div>
        @else
            <form method="POST" action="{{ route('service-records.store') }}" class="grid gap-5 md:grid-cols-2">
                @csrf

                <div class="md:col-span-2">
                    <label class="field-label" for="appointment_id">Completed Appointment</label>
                    <select id="appointment_id" name="appointment_id" class="field-select">
                        @foreach ($appointments as $appointment)
                            <option value="{{ $appointment->id }}">
                                #{{ $appointment->id }} - {{ $appointment->client->full_name }} - {{ $appointment->service_type }} - {{ $appointment->staff->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="field-hint">Only completed appointments without an existing record appear in this list.</p>
                </div>

                <div>
                    <label class="field-label" for="service_date">Service Date</label>
                    <input id="service_date" type="date" name="service_date" value="{{ old('service_date', now()->toDateString()) }}" class="field-input">
                </div>

                <div class="md:col-span-2">
                    <label class="field-label" for="description">Description</label>
                    <textarea id="description" name="description" class="field-textarea" placeholder="Describe the service performed, outcomes, and key observations.">{{ old('description') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="field-label" for="remarks">Remarks</label>
                    <textarea id="remarks" name="remarks" class="field-textarea" placeholder="Optional follow-up instructions or notes.">{{ old('remarks') }}</textarea>
                </div>

                <div class="md:col-span-2 flex flex-wrap items-center gap-3">
                    <button class="btn-primary" type="submit">Save Service Record</button>
                    <a href="{{ route('service-records.index') }}" class="btn-ghost">Back to Records</a>
                </div>
            </form>
        @endif
    </section>
@endsection
