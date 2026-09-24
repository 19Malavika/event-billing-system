<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Registration') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="editRegistrationForm({{ $registration->event->registration_fee ?? 0 }}, {{ $registration->tickets_count }}, {{ $registration->additional_workshop ? 'true' : 'false' }}, '{{ $registration->food_preference }}')">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('registrations.update', $registration) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Event Selection -->
                    <div>
                        <label for="event_id" class="block text-sm font-medium text-gray-700">Select Event</label>
                        <select name="event_id" id="event_id" x-model="selectedEventId" @change="updateEventFee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" data-fee="{{ $event->registration_fee }}" {{ $registration->event_id == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }} (Fee: ₹{{ $event->registration_fee }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Participant Selection -->
                    <div>
                        <label for="participant_id" class="block text-sm font-medium text-gray-700">Select Participant</label>
                        <select name="participant_id" id="participant_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach($participants as $participant)
                                <option value="{{ $participant->id }}" {{ $registration->participant_id == $participant->id ? 'selected' : '' }}>
                                    {{ $participant->name }} ({{ $participant->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tickets Count -->
                    <div>
                        <label for="tickets_count" class="block text-sm font-medium text-gray-700">Number of Tickets</label>
                        <input type="number" name="tickets_count" id="tickets_count" x-model.number="tickets" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <!-- Registration Date -->
                    <div>
                        <label for="registration_date" class="block text-sm font-medium text-gray-700">Registration Date</label>
                        <input type="datetime-local" name="registration_date" id="registration_date" value="{{ old('registration_date', $registration->registration_date->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <!-- Additional Options -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center space-x-3 border p-4 rounded-md">
                            <input type="hidden" name="additional_workshop" value="0">
                            <input type="checkbox" name="additional_workshop" id="additional_workshop" value="1" x-model="hasWorkshop" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="additional_workshop" class="text-sm font-medium text-gray-700">Include Additional Workshop (+₹200/ticket)</label>
                        </div>

                        <div>
                            <label for="food_preference" class="block text-sm font-medium text-gray-700">Food Preference</label>
                            <select name="food_preference" id="food_preference" x-model="foodPreference" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">None</option>
                                <option value="Vegetarian">Vegetarian (+₹150/ticket)</option>
                                <option value="Non-Vegetarian">Non-Vegetarian (+₹150/ticket)</option>
                                <option value="Vegan">Vegan (+₹150/ticket)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="pending" {{ $registration->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $registration->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $registration->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $registration->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <!-- Live Billing Summary Box -->
                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg space-y-2">
                        <h3 class="font-semibold text-gray-800 border-b pb-2">Billing Breakdown Summary</h3>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal:</span>
                            <span x-text="'₹' + subtotal.toFixed(2)"></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span x-text="'Discount (' + discountPercentage + '%):'"></span>
                            <span x-text="'- ₹' + discountAmount.toFixed(2)"></span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-gray-900 border-t pt-2">
                            <span>Final Amount:</span>
                            <span x-text="'₹' + finalAmount.toFixed(2)"></span>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('registrations.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-300">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">Update Registration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Alpine.js Live Calculation Script for Edit -->
    <script>
        function editRegistrationForm(initialFee, initialTickets, initialWorkshop, initialFood) {
            return {
                selectedEventId: '{{ $registration->event_id }}',
                eventFee: initialFee,
                tickets: initialTickets,
                hasWorkshop: initialWorkshop,
                foodPreference: initialFood,

                updateEventFee(event) {
                    let selectedOption = event.target.options[event.target.selectedIndex];
                    this.eventFee = parseFloat(selectedOption.getAttribute('data-fee')) || 0;
                },

                get subtotal() {
                    let workshopCost = this.hasWorkshop ? (200 * this.tickets) : 0;
                    let foodCost = this.foodPreference ? (150 * this.tickets) : 0;
                    return (this.eventFee * this.tickets) + workshopCost + foodCost;
                },

                get discountPercentage() {
                    if (this.tickets >= 5) return 10;
                    if (this.tickets >= 3) return 5;
                    return 0;
                },

                get discountAmount() {
                    return (this.subtotal * this.discountPercentage) / 100;
                },

                get finalAmount() {
                    return this.subtotal - this.discountAmount;
                }
            }
        }
    </script>
</x-app-layout>