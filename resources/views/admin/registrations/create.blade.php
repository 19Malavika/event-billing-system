<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Event Registration & Billing') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="registrationForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">
                            Please fix the following errors:
                        </strong>

                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('registrations.store') }}"
                    method="POST"
                    class="space-y-6"
                >
                    @csrf

                    {{-- Event Selection --}}
                    <div>
                        <label
                            for="event_id"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Select Event
                        </label>

                        <select
                            name="event_id"
                            id="event_id"
                            x-model="selectedEventId"
                            @change="updateEventFee"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="">
                                -- Choose Published Event --
                            </option>

                            @foreach($events as $event)
                                <option
                                    value="{{ $event->id }}"
                                    data-fee="{{ $event->registration_fee }}"
                                    data-workshop-fee="{{ $event->workshop_fee }}"
                                    data-food-fee="{{ $event->food_fee }}"
                                    data-seats="{{ $event->available_seats }}"
                                >
                                    {{ $event->title }}
                                    (Fee: ₹{{ number_format($event->registration_fee, 2) }}
                                    | Seats Left: {{ $event->available_seats }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Participant Selection --}}
                    <div>
                        <label
                            for="participant_id"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Select Participant
                        </label>

                        <select
                            name="participant_id"
                            id="participant_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="">
                                -- Choose Participant --
                            </option>

                            @foreach($participants as $participant)
                                <option value="{{ $participant->id }}">
                                    {{ $participant->name }}
                                    ({{ $participant->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tickets Count --}}
                    <div>
                        <label
                            for="tickets_count"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Number of Tickets
                        </label>

                        <input
                            type="number"
                            name="tickets_count"
                            id="tickets_count"
                            x-model.number="tickets"
                            min="1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >

                        <p class="text-xs text-gray-500 mt-1">
                            Volume Discount:
                            3-4 tickets = 5% off,
                            5+ tickets = 10% off
                        </p>
                    </div>

                    {{-- Registration Date --}}
                    <div>
                        <label
                            for="registration_date"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Registration Date
                        </label>

                        <input
                            type="datetime-local"
                            name="registration_date"
                            id="registration_date"
                            value="{{ old('registration_date', now()->format('Y-m-d\TH:i')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                    </div>

                    {{-- Additional Options --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Workshop --}}
                        <div class="flex items-center space-x-3 border p-4 rounded-md">

                            <input
                                type="hidden"
                                name="additional_workshop"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                name="additional_workshop"
                                id="additional_workshop"
                                value="1"
                                x-model="hasWorkshop"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            >

                            <label
                                for="additional_workshop"
                                class="text-sm font-medium text-gray-700"
                            >
                                Include Additional Workshop
                                (<span x-text="'₹' + workshopFee.toFixed(2)"></span>/ticket)
                            </label>

                        </div>

                        {{-- Food --}}
                        <div>
                            <label
                                for="food_preference"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Food Preference
                            </label>

                            <select
                                name="food_preference"
                                id="food_preference"
                                x-model="foodPreference"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">None</option>

                                <option value="Vegetarian">
                                    Vegetarian
                                    (+<span x-text="'₹' + foodFee.toFixed(2)"></span>/ticket)
                                </option>

                                <option value="Non-Vegetarian">
                                    Non-Vegetarian
                                    (+<span x-text="'₹' + foodFee.toFixed(2)"></span>/ticket)
                                </option>

                                <option value="Vegan">
                                    Vegan
                                    (+<span x-text="'₹' + foodFee.toFixed(2)"></span>/ticket)
                                </option>
                            </select>
                        </div>

                    </div>

                    {{-- Payment Status --}}
                    <div>
                        <label
                            for="payment_status"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Payment Status
                        </label>

                        <select
                            name="payment_status"
                            id="payment_status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>

                    {{-- Billing Summary --}}
                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg space-y-3">

                        <h3 class="font-semibold text-gray-800 border-b pb-2">
                            Billing Breakdown Summary
                        </h3>

                        {{-- Event Fee --}}
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Event Fee:</span>

                            <span x-text="'₹' + eventFeeTotal.toFixed(2)"></span>
                        </div>

                        {{-- Workshop Fee --}}
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Workshop Fee:</span>

                            <span x-text="'₹' + workshopTotal.toFixed(2)"></span>
                        </div>

                        {{-- Food Fee --}}
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Food Fee:</span>

                            <span x-text="'₹' + foodTotal.toFixed(2)"></span>
                        </div>

                        {{-- Subtotal --}}
                        <div class="flex justify-between text-sm font-medium text-gray-700 border-t pt-2">
                            <span>Subtotal:</span>

                            <span x-text="'₹' + subtotal.toFixed(2)"></span>
                        </div>

                        {{-- Discount Percentage --}}
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>
                                Discount:
                                <span x-text="discountPercentage + '%'"></span>
                            </span>

                            <span>
                                - ₹<span x-text="discountAmount.toFixed(2)"></span>
                            </span>
                        </div>

                        {{-- Final Amount --}}
                        <div class="flex justify-between text-base font-bold text-gray-900 border-t pt-2">
                            <span>Final Amount:</span>

                            <span x-text="'₹' + finalAmount.toFixed(2)"></span>
                        </div>

                    </div>

                    {{-- Submit Buttons --}}
                    <div class="flex justify-end space-x-3">

                        <a
                            href="{{ route('registrations.index') }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-300"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700"
                        >
                            Complete Registration
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Alpine.js Live Calculation --}}
    <script>
        function registrationForm() {
            return {

                selectedEventId: '',

                eventFee: 0,

                workshopFee: 0,

                foodFee: 0,

                tickets: 1,

                hasWorkshop: false,

                foodPreference: '',


                updateEventFee(event) {

                    let selectedOption =
                        event.target.options[event.target.selectedIndex];

                    this.eventFee =
                        parseFloat(
                            selectedOption.getAttribute('data-fee')
                        ) || 0;

                    this.workshopFee =
                        parseFloat(
                            selectedOption.getAttribute('data-workshop-fee')
                        ) || 0;

                    this.foodFee =
                        parseFloat(
                            selectedOption.getAttribute('data-food-fee')
                        ) || 0;
                },


                get eventFeeTotal() {

                    return this.eventFee * this.tickets;

                },


                get workshopTotal() {

                    return this.hasWorkshop
                        ? this.workshopFee * this.tickets
                        : 0;

                },


                get foodTotal() {

                    return this.foodPreference
                        ? this.foodFee * this.tickets
                        : 0;

                },


                get subtotal() {

                    return (
                        this.eventFeeTotal +
                        this.workshopTotal +
                        this.foodTotal
                    );

                },


                get discountPercentage() {

                    if (this.tickets >= 5) {
                        return 10;
                    }

                    if (this.tickets >= 3) {
                        return 5;
                    }

                    return 0;

                },


                get discountAmount() {

                    return (
                        this.subtotal *
                        this.discountPercentage
                    ) / 100;

                },


                get finalAmount() {

                    return (
                        this.subtotal -
                        this.discountAmount
                    );

                }

            }
        }
    </script>

</x-app-layout>