@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <section class="flex flex-col gap-4">
        <span class="kicker">Admin Module</span>
        <div>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900">System Settings</h1>
            <p class="mt-2 max-w-2xl text-xs text-slate-500">Configure the clinic branding and operational details shown across the appointment management system.</p>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
        <article class="app-card px-6 py-6">
            <form method="POST" action="{{ route('settings.update') }}" class="grid gap-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="field-label" for="system_name">System Name</label>
                    <input id="system_name" type="text" name="system_name" value="{{ old('system_name', $settings['system_name']) }}" class="field-input">
                </div>

                <div>
                    <label class="field-label" for="system_tagline">Tagline</label>
                    <textarea id="system_tagline" name="system_tagline" class="field-textarea">{{ old('system_tagline', $settings['system_tagline']) }}</textarea>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="field-label" for="support_email">Support Email</label>
                        <input id="support_email" type="email" name="support_email" value="{{ old('support_email', $settings['support_email']) }}" class="field-input">
                    </div>
                    <div>
                        <label class="field-label" for="clinic_phone">Clinic Phone</label>
                        <input id="clinic_phone" type="text" name="clinic_phone" value="{{ old('clinic_phone', $settings['clinic_phone']) }}" class="field-input">
                    </div>
                </div>

                <div>
                    <label class="field-label" for="clinic_address">Clinic Address</label>
                    <input id="clinic_address" type="text" name="clinic_address" value="{{ old('clinic_address', $settings['clinic_address']) }}" class="field-input">
                </div>

                <div>
                    <label class="field-label" for="business_hours">Business Hours</label>
                    <input id="business_hours" type="text" name="business_hours" value="{{ old('business_hours', $settings['business_hours']) }}" class="field-input">
                </div>

                <div class="flex flex-wrap gap-3">
                    <button class="btn-primary" type="submit">Save Settings</button>
                </div>
            </form>
        </article>

        <article class="app-card px-6 py-6">
            <h2 class="text-xl font-bold text-slate-900">Preview</h2>
            <p class="mt-2 text-sm text-slate-500">These values are reused in the login page, layout header, and system summaries.</p>

            <div class="mt-6 rounded-[1.75rem] bg-slate-900 px-6 py-6 text-white">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/furmend-mark.svg') }}" alt="" class="h-16 w-16 rounded-[1.25rem] bg-white">
                    <div>
                        <p class="text-xl font-bold">{{ $settings['system_name'] }}</p>
                        <p class="mt-1 text-sm text-white/70">{{ $settings['system_tagline'] }}</p>
                    </div>
                </div>

                <div class="mt-6 space-y-3 text-sm text-white/80">
                    <p><span class="font-semibold text-white">Support:</span> {{ $settings['support_email'] }}</p>
                    <p><span class="font-semibold text-white">Phone:</span> {{ $settings['clinic_phone'] }}</p>
                    <p><span class="font-semibold text-white">Address:</span> {{ $settings['clinic_address'] }}</p>
                    <p><span class="font-semibold text-white">Hours:</span> {{ $settings['business_hours'] }}</p>
                </div>
            </div>
        </article>
    </section>
@endsection
