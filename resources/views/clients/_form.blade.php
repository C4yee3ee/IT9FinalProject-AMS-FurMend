@csrf

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="field-label" for="first_name">First Name <span class="text-red-500">*</span></label>
        <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $client->first_name ?? '') }}"
            class="field-input" placeholder="e.g., John">
    </div>

    <div>
        <label class="field-label" for="last_name">Last Name <span class="text-red-500">*</span></label>
        <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $client->last_name ?? '') }}"
            class="field-input" placeholder="e.g., Smith">
    </div>

    <div>
        <label class="field-label" for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $client->email ?? '') }}" class="field-input"
            placeholder="john.smith@email.com">
    </div>

    <div>
        <label class="field-label" for="phone">Phone <span class="text-red-500">*</span></label>
        <input id="phone" type="text" name="phone" value="{{ old('phone', $client->phone ?? '') }}" class="field-input"
            placeholder="(555) 123-4567">
    </div>

    <div class="md:col-span-2">
        <label class="field-label" for="address">Address</label>
        <input id="address" type="text" name="address" value="{{ old('address', $client->address ?? '') }}"
            class="field-input" placeholder="123 Main St, Anytown, USA">
    </div>
</div>

<div class="border-t border-[rgba(38,166,154,0.2)] my-5"></div>
<p class="text-sm font-bold text-slate-700 mb-3">Pet Information <span
        class="text-xs font-normal text-slate-400">(Optional)</span></p>
<div class="grid gap-4 md:grid-cols-3">
    <div>
        <label class="field-label" for="pet_name">Pet Name</label>
        <input id="pet_name" type="text" name="pet_name" value="{{ old('pet_name', $client->pet_name ?? '') }}"
            class="field-input" placeholder="e.g., Max">
    </div>
    <div>
        <label class="field-label" for="pet_species">Species</label>
        <input id="pet_species" type="text" name="pet_species"
            value="{{ old('pet_species', $client->pet_species ?? '') }}" class="field-input" placeholder="e.g., Dog">
    </div>
    <div>
        <label class="field-label" for="pet_breed">Breed</label>
        <input id="pet_breed" type="text" name="pet_breed" value="{{ old('pet_breed', $client->pet_breed ?? '') }}"
            class="field-input" placeholder="e.g., Golden Retriever">
    </div>
</div>

<div class="mt-4">
    <label class="field-label" for="notes">Notes</label>
    <textarea id="notes" name="notes" class="field-textarea"
        placeholder="Additional notes or special instructions...">{{ old('notes', $client->notes ?? '') }}</textarea>
    <p class="field-hint">Use this for intake notes, follow-up reminders, or client preferences.</p>
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button class="btn-primary" type="submit">Save Client</button>
    <a href="{{ route('clients.index') }}" class="btn-ghost">Back to Clients</a>
</div>