<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Edit Registration') }}
        </h2>
    </x-slot>

    <div
        class="py-12 bg-slate-900 min-h-screen"
        x-data="editRegistrationForm(
            {{ $registration->event->registration_fee ?? 0 }},
            {{ $registration->event->workshop_fee ?? 0 }},
            {{ $registration->event->food_fee ?? 0 }},
            {{ $registration->tickets_count }},
            {{ $registration->additional_workshop ? 'true' : 'false' }},
            @js($registration->food_preference)
        )"
    >
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-slate-800 border border-slate-700 overflow-hidden shadow-lg sm:rounded-lg p-6">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-900/40 border border-red-700 text-red-200 px-4 py-3 rounded">
                        <strong class="font-bold">Please fix the following errors:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('registrations.update', $registration) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Event Selection --}}
                    <div>
                        <label for="event_id" class="block text-sm font-medium text-gray-300">
                            Select Event
                        </label>
                        <select name="event_id" id="event_id"
                                x-model="selectedEventId"
                                @change="updateEventFee"
                                class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}"
                                        data-fee="{{ $event->registration_fee }}"
                                        data-workshop-fee="{{ $event->workshop_fee }}"
                                        data-food-fee="{{ $event->food_fee }}"
                                        data-seats="{{ $event->available_seats }}"
                                        class="bg-slate-900"
                                        {{ $registration->event_id == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                    (Fee: ₹{{ number_format($event->registration_fee, 2) }}
                                    | Seats Left: {{ $event->available_seats }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Participant Selection --}}
                    <div>
                        <label for="participant_id" class="block text-sm font-medium text-gray-300">
                            Select Participant
                        </label>
                        <select name="participant_id" id="participant_id"
                                class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            @foreach($participants as $participant)
                                <option value="{{ $participant->id }}"
                                        class="bg-slate-900"
                                        {{ $registration->participant_id == $participant->id ? 'selected' : '' }}>
                                    {{ $participant->name }} ({{ $participant->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tickets Count --}}
                    <div>
                        <label for="tickets_count" class="block text-sm font-medium text-gray-300">
                            Number of Tickets
                        </label>
                        <input type="number" name="tickets_count" id="tickets_count"
                               x-model.number="tickets"
                               min="1"
                               class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required>
                        <p class="text-xs text-gray-400 mt-1">
                            Volume Discount: 3-4 tickets = 5% off, 5+ tickets = 10% off
                        </p>
                    </div>

                    {{-- Registration Date --}}
                    <div>
                        <label for="registration_date" class="block text-sm font-medium text-gray-300">
                            Registration Date
                        </label>
                        <input type="datetime-local" name="registration_date" id="registration_date"
                               value="{{ old('registration_date', $registration->registration_date->format('Y-m-d\TH:i')) }}"
                               class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 [color-scheme:dark]"
                               required>
                    </div>

                    {{-- Additional Options --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Workshop --}}
                        <div class="flex items-center space-x-3 border border-slate-600 bg-slate-900/50 p-4 rounded-md">
                            <input type="hidden" name="additional_workshop" value="0">
                            <input type="checkbox" name="additional_workshop" id="additional_workshop"
                                   value="1"
                                   x-model="hasWorkshop"
                                   class="rounded bg-slate-900 border-slate-600 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="additional_workshop" class="text-sm font-medium text-gray-300">
                                Include Additional Workshop
                                (<span x-text="'₹' + workshopFee.toFixed(2)"></span>/ticket)
                            </label>
                        </div>

                        {{-- Food --}}
                        <div>
                            <label for="food_preference" class="block text-sm font-medium text-gray-300">
                                Food Preference
                            </label>
                            <select name="food_preference" id="food_preference"
                                    x-model="foodPreference"
                                    class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" class="bg-slate-900">None</option>
                                <option value="Vegetarian" class="bg-slate-900">
                                    Vegetarian (+₹<span x-text="foodFee.toFixed(2)"></span>/ticket)
                                </option>
                                <option value="Non-Vegetarian" class="bg-slate-900">
                                    Non-Vegetarian (+₹<span x-text="foodFee.toFixed(2)"></span>/ticket)
                                </option>
                                <option value="Vegan" class="bg-slate-900">
                                    Vegan (+₹<span x-text="foodFee.toFixed(2)"></span>/ticket)
                                </option>
                            </select>
                        </div>

                    </div>

                    {{-- Payment Status --}}
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-300">
                            Payment Status
                        </label>
                        <select name="payment_status" id="payment_status"
                                class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            <option value="pending"  class="bg-slate-900" {{ $registration->payment_status == 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="paid"     class="bg-slate-900" {{ $registration->payment_status == 'paid'     ? 'selected' : '' }}>Paid</option>
                            <option value="failed"   class="bg-slate-900" {{ $registration->payment_status == 'failed'   ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" class="bg-slate-900" {{ $registration->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    {{-- Billing Summary --}}
                    <div class="bg-slate-900 border border-slate-700 p-4 rounded-lg space-y-3">

                        <h3 class="font-semibold text-gray-100 border-b border-slate-700 pb-2">
                            Billing Breakdown Summary
                        </h3>

                        <div class="flex justify-between text-sm text-gray-300">
                            <span>Event Fee:</span>
                            <span x-text="'₹' + eventFeeTotal.toFixed(2)"></span>
                        </div>

                        <div class="flex justify-between text-sm text-gray-300">
                            <span>Workshop Fee:</span>
                            <span x-text="'₹' + workshopTotal.toFixed(2)"></span>
                        </div>

                        <div class="flex justify-between text-sm text-gray-300">
                            <span>Food Fee:</span>
                            <span x-text="'₹' + foodTotal.toFixed(2)"></span>
                        </div>

                        <div class="flex justify-between text-sm font-medium text-gray-200 border-t border-slate-700 pt-2">
                            <span>Subtotal:</span>
                            <span x-text="'₹' + subtotal.toFixed(2)"></span>
                        </div>

                        <div class="flex justify-between text-sm text-gray-300">
                            <span>
                                Discount:
                                <span x-text="discountPercentage + '%'"></span>
                            </span>
                            <span>
                                - ₹<span x-text="discountAmount.toFixed(2)"></span>
                            </span>
                        </div>

                        <div class="flex justify-between text-base font-bold text-gray-100 border-t border-slate-700 pt-2">
                            <span>Final Amount:</span>
                            <span class="text-indigo-400" x-text="'₹' + finalAmount.toFixed(2)"></span>
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('registrations.index') }}"
                           class="bg-slate-700 text-gray-200 px-4 py-2 rounded-md text-sm hover:bg-slate-600 transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700 transition">
                            Update Registration
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Alpine.js Live Calculation --}}
    <script>
        function editRegistrationForm(
            initialFee,
            initialWorkshopFee,
            initialFoodFee,
            initialTickets,
            initialWorkshop,
            initialFood
        ) {
            return {
                selectedEventId: '{{ $registration->event_id }}',
                eventFee: initialFee,
                workshopFee: initialWorkshopFee,
                foodFee: initialFoodFee,
                tickets: initialTickets,
                hasWorkshop: initialWorkshop,
                foodPreference: initialFood,

                updateEventFee(event) {
                    let selectedOption = event.target.options[event.target.selectedIndex];
                    this.eventFee    = parseFloat(selectedOption.getAttribute('data-fee'))          || 0;
                    this.workshopFee = parseFloat(selectedOption.getAttribute('data-workshop-fee')) || 0;
                    this.foodFee     = parseFloat(selectedOption.getAttribute('data-food-fee'))     || 0;
                },

                get eventFeeTotal()  { return this.eventFee * this.tickets; },
                get workshopTotal()  { return this.hasWorkshop ? this.workshopFee * this.tickets : 0; },
                get foodTotal()      { return this.foodPreference ? this.foodFee * this.tickets : 0; },
                get subtotal()       { return this.eventFeeTotal + this.workshopTotal + this.foodTotal; },

                get discountPercentage() {
                    if (this.tickets >= 5) return 10;
                    if (this.tickets >= 3) return 5;
                    return 0;
                },

                get discountAmount() { return (this.subtotal * this.discountPercentage) / 100; },
                get finalAmount()    { return this.subtotal - this.discountAmount; }
            }
        }
    </script>

</x-app-layout>