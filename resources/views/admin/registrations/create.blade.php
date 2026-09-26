<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 tracking-tight leading-tight">
            {{ __('New Event Registration & Billing') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="registrationForm()">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-2 border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm relative">
                    <strong class="font-extrabold block mb-1">
                        Please fix the following errors:
                    </strong>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('registrations.store') }}"
                method="POST"
                class="grid grid-cols-1 lg:grid-cols-3 gap-8"
            >
                @csrf

                {{-- Left Side: Form Inputs (2 Columns wide) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white shadow-xl rounded-3xl p-8 border border-gray-100">
                        
                        <h3 class="text-lg font-extrabold text-gray-900 mb-6 pb-3 border-b border-gray-100">
                            Participant & Event Details
                        </h3>

                        <div class="space-y-5">
                            {{-- Event Selection --}}
                            <div>
                                <label for="event_id" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                                    Select Event
                                </label>
                                <select
                                    name="event_id"
                                    id="event_id"
                                    x-model="selectedEventId"
                                    @change="updateEventFee"
                                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8] text-sm py-3"
                                    required
                                >
                                    <option value="">-- Choose Published Event --</option>
                                    @foreach($events as $event)
                                        <option
                                            value="{{ $event->id }}"
                                            data-fee="{{ $event->registration_fee }}"
                                            data-workshop-fee="{{ $event->workshop_fee }}"
                                            data-food-fee="{{ $event->food_fee }}"
                                            data-seats="{{ $event->available_seats }}"
                                        >
                                            {{ $event->title }} (Fee: ₹{{ number_format($event->registration_fee, 2) }} | Seats Left: {{ $event->available_seats }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Participant Selection --}}
                            <div>
                                <label for="participant_id" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                                    Select Participant
                                </label>
                                <select
                                    name="participant_id"
                                    id="participant_id"
                                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8] text-sm py-3"
                                    required
                                >
                                    <option value="">-- Choose Participant --</option>
                                    @foreach($participants as $participant)
                                        <option value="{{ $participant->id }}">
                                            {{ $participant->name }} ({{ $participant->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                {{-- Tickets Count --}}
                                <div>
                                    <label for="tickets_count" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                                        Number of Tickets
                                    </label>
                                    <input
                                        type="number"
                                        name="tickets_count"
                                        id="tickets_count"
                                        x-model.number="tickets"
                                        min="1"
                                        step="1"
                                        class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8] text-sm py-3"
                                        required
                                    >
                                    <p class="text-[11px] text-gray-400 mt-1.5 font-medium">
                                        Discount: 3-4 tickets = 5% off, 5+ = 10% off
                                    </p>
                                </div>

                                {{-- Registration Date --}}
                                <div>
                                    <label for="registration_date" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                                        Registration Date
                                    </label>
                                    <input
                                        type="datetime-local"
                                        name="registration_date"
                                        id="registration_date"
                                        value="{{ old('registration_date', now()->format('Y-m-d\TH:i')) }}"
                                        class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8] text-sm py-3"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Additional Options Section --}}
                            <div class="pt-4 border-t border-gray-100 space-y-4">
                                <h4 class="text-xs font-extrabold uppercase tracking-widest text-gray-400">Add-ons & Payment</h4>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    {{-- Workshop Toggle --}}
                                    <div class="flex items-center space-x-3 border border-gray-200 p-4 rounded-2xl bg-gray-50/50 hover:bg-gray-50 transition">
                                        <input type="hidden" name="additional_workshop" value="0">
                                        <input
                                            type="checkbox"
                                            name="additional_workshop"
                                            id="additional_workshop"
                                            value="1"
                                            x-model="hasWorkshop"
                                            class="rounded border-gray-300 text-[#2874B8] shadow-sm focus:ring-[#2874B8] w-5 h-5"
                                        >
                                        <label for="additional_workshop" class="text-xs font-bold text-gray-700 cursor-pointer">
                                            Include Workshop 
                                            <span class="block text-[10px] text-gray-400 font-normal" x-text="'+₹' + workshopFee.toFixed(2) + '/ticket'"></span>
                                        </label>
                                    </div>

                                    {{-- Food Preference --}}
                                    <div>
                                        <label for="food_preference" class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">
                                            Food Package
                                        </label>
                                        <select
                                            name="food_preference"
                                            id="food_preference"
                                            x-model="foodPreference"
                                            class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8] text-sm py-2.5"
                                        >
                                            <option value="">None</option>
                                            <option value="Vegetarian">Vegetarian</option>
                                            <option value="Non-Vegetarian">Non-Vegetarian</option>
                                            <option value="Vegan">Vegan</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Payment Status --}}
                                <div>
                                    <label for="payment_status" class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">
                                        Payment Status
                                    </label>
                                    <select
                                        name="payment_status"
                                        id="payment_status"
                                        class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8] text-sm py-3"
                                        required
                                    >
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="failed">Failed</option>
                                        <option value="refunded">Refunded</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Right Side: Sticky Billing Summary Card (1 Column wide) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-xl rounded-3xl p-6 border border-gray-100 sticky top-6 space-y-5">
                        
                        <div class="bg-gray-900 text-white -mx-6 -mt-6 p-6 rounded-t-3xl">
                            <h3 class="font-extrabold text-base tracking-wide">
                                Billing Summary
                            </h3>
                            <p class="text-xs text-gray-400 mt-0.5">Real-time calculations</p>
                        </div>

                        <div class="space-y-3 text-sm text-gray-600 pt-2">
                            <div class="flex justify-between">
                                <span>Event Fee:</span>
                                <span class="font-bold text-gray-900" x-text="'₹' + eventFeeTotal.toFixed(2)"></span>
                            </div>

                            <div class="flex justify-between" x-show="hasWorkshop">
                                <span>Workshop Fee:</span>
                                <span class="font-bold text-gray-900" x-text="'₹' + workshopTotal.toFixed(2)"></span>
                            </div>

                            <div class="flex justify-between" x-show="foodPreference">
                                <span>Food Package:</span>
                                <span class="font-bold text-gray-900" x-text="'₹' + foodTotal.toFixed(2)"></span>
                            </div>

                            <div class="border-t border-gray-100 pt-3 flex justify-between font-medium text-gray-800">
                                <span>Subtotal:</span>
                                <span x-text="'₹' + subtotal.toFixed(2)"></span>
                            </div>

                            <div class="flex justify-between text-emerald-600 text-xs font-bold" x-show="discountPercentage > 0">
                                <span>Discount (<span x-text="discountPercentage + '%'"></span>):</span>
                                <span x-text="'- ₹' + discountAmount.toFixed(2)"></span>
                            </div>
                        </div>

                        <div class="border-t border-dashed border-gray-200 pt-4 flex justify-between items-center">
                            <span class="font-extrabold text-gray-900 text-base">Final Amount</span>
                            <span class="font-black text-indigo-600 text-2xl" x-text="'₹' + finalAmount.toFixed(2)"></span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="space-y-3 pt-2">
                            <button
                                type="submit"
                                class="w-full bg-[#2874B8] hover:bg-[#215d96] text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-500/20 transition text-sm text-center"
                            >
                                Complete Registration
                            </button>

                            <a
                                href="{{ route('registrations.index') }}"
                                class="w-full block text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-xl transition text-sm"
                            >
                                Cancel
                            </a>
                        </div>

                    </div>
                </div>

            </form>

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
                    let selectedOption = event.target.options[event.target.selectedIndex];
                    this.eventFee = parseFloat(selectedOption.getAttribute('data-fee')) || 0;
                    this.workshopFee = parseFloat(selectedOption.getAttribute('data-workshop-fee')) || 0;
                    this.foodFee = parseFloat(selectedOption.getAttribute('data-food-fee')) || 0;
                },

                get eventFeeTotal() {
                    return this.eventFee * this.tickets;
                },

                get workshopTotal() {
                    return this.hasWorkshop ? (this.workshopFee * this.tickets) : 0;
                },

                get foodTotal() {
                    return (this.foodPreference && this.foodPreference !== '') ? (this.foodFee * this.tickets) : 0;
                },

                get subtotal() {
                    return this.eventFeeTotal + this.workshopTotal + this.foodTotal;
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