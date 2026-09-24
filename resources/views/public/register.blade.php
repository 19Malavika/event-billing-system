<x-public-layout>

    <div
        class="py-12"
        x-data="registrationForm()"
    >

        <div class="max-w-5xl mx-auto px-4">

            {{-- Page Heading --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">
                    Register for {{ $event->title }}
                </h1>

                <p class="mt-2 text-gray-600">
                    Complete your details and review your billing before registering.
                </p>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg">

                    <strong class="font-semibold">
                        Please fix the following errors:
                    </strong>

                    <ul class="list-disc list-inside text-sm mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <form
                action="{{ route('events.register.store', $event) }}"
                method="POST"
                class="grid grid-cols-1 lg:grid-cols-3 gap-6"
            >
                @csrf

                {{-- Registration Form --}}
                <div class="lg:col-span-2 bg-white shadow-sm rounded-lg p-6 space-y-6">

                    {{-- Participant Details --}}
                    <div>

                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            Participant Details
                        </h2>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Name --}}
                        <div>

                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >

                        </div>

                        {{-- Email --}}
                        <div>

                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >

                        </div>

                        {{-- Phone --}}
                        <div>

                            <label
                                for="phone"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Phone
                            </label>

                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                value="{{ old('phone') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >

                        </div>

                        {{-- Gender --}}
                        <div>

                            <label
                                for="gender"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Gender
                            </label>

                            <select
                                name="gender"
                                id="gender"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            >

                                <option value="">
                                    Select Gender
                                </option>

                                <option
                                    value="Male"
                                    {{ old('gender') === 'Male' ? 'selected' : '' }}
                                >
                                    Male
                                </option>

                                <option
                                    value="Female"
                                    {{ old('gender') === 'Female' ? 'selected' : '' }}
                                >
                                    Female
                                </option>

                                <option
                                    value="Other"
                                    {{ old('gender') === 'Other' ? 'selected' : '' }}
                                >
                                    Other
                                </option>

                            </select>

                        </div>

                        {{-- Course / Department --}}
                        <div class="md:col-span-2">

                            <label
                                for="department"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Course / Department
                            </label>

                            <input
                                type="text"
                                name="department"
                                id="department"
                                value="{{ old('department') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >

                        </div>

                    </div>

                    <hr>

                    {{-- Registration Options --}}
                    <h2 class="text-xl font-bold text-gray-900">
                        Registration Options
                    </h2>

                    {{-- Tickets --}}
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
                            min="1"
                            max="{{ $event->available_seats }}"
                            x-model.number="tickets"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            required
                        >

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $event->available_seats }} seats available.
                        </p>

                    </div>

                    {{-- Workshop --}}
                    <div class="border rounded-lg p-4">

                        <label class="flex items-center gap-3">

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
                                class="rounded border-gray-300"
                            >

                            <span class="text-sm font-medium text-gray-700">

                                Include Workshop

                                (+₹{{ number_format($event->workshop_fee, 2) }}/ticket)

                            </span>

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
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >

                            <option value="">
                                No Food
                            </option>

                            <option value="Vegetarian">
                                Vegetarian
                            </option>

                            <option value="Non-Vegetarian">
                                Non-Vegetarian
                            </option>

                            <option value="Vegan">
                                Vegan
                            </option>

                        </select>

                        <p class="text-xs text-gray-500 mt-1">
                            Food fee:
                            ₹{{ number_format($event->food_fee, 2) }}/ticket
                        </p>

                    </div>

                    {{-- Payment Option --}}
                    <div>

                        <label
                            for="payment_status"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Payment Option
                        </label>

                        <select
                            name="payment_status"
                            id="payment_status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            required
                        >

                            <option
                                value="pending"
                                {{ old('payment_status', 'pending') === 'pending' ? 'selected' : '' }}
                            >
                                Pay Later / Pending
                            </option>

                            <option
                                value="paid"
                                {{ old('payment_status') === 'paid' ? 'selected' : '' }}
                            >
                                Paid
                            </option>

                        </select>

                    </div>

                    {{-- Registration Date --}}
                    <input
                        type="hidden"
                        name="registration_date"
                        value="{{ now()->format('Y-m-d\TH:i') }}"
                    >

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700"
                    >
                        Complete Registration
                    </button>

                </div>

                {{-- Billing Summary --}}
                <div class="bg-white shadow-sm rounded-lg p-6 h-fit">

                    <h2 class="text-xl font-bold text-gray-900 border-b pb-4">
                        Billing Summary
                    </h2>

                    <div class="mt-5 space-y-3 text-sm">

                        {{-- Event Fee --}}
                        <div class="flex justify-between">

                            <span>
                                Event Fee
                            </span>

                            <span>
                                ₹<span x-text="eventFeeTotal.toFixed(2)"></span>
                            </span>

                        </div>

                        {{-- Workshop Fee --}}
                        <div class="flex justify-between">

                            <span>
                                Workshop Fee
                            </span>

                            <span>
                                ₹<span x-text="workshopTotal.toFixed(2)"></span>
                            </span>

                        </div>

                        {{-- Food Fee --}}
                        <div class="flex justify-between">

                            <span>
                                Food Fee
                            </span>

                            <span>
                                ₹<span x-text="foodTotal.toFixed(2)"></span>
                            </span>

                        </div>

                        {{-- Subtotal --}}
                        <div class="border-t pt-3 flex justify-between font-semibold">

                            <span>
                                Subtotal
                            </span>

                            <span>
                                ₹<span x-text="subtotal.toFixed(2)"></span>
                            </span>

                        </div>

                        {{-- Discount --}}
                        <div class="flex justify-between text-green-600">

                            <span>
                                Discount
                                (<span x-text="discountPercentage"></span>%)
                            </span>

                            <span>
                                - ₹<span x-text="discountAmount.toFixed(2)"></span>
                            </span>

                        </div>

                        {{-- Final Amount --}}
                        <div class="border-t pt-4 flex justify-between text-lg font-bold">

                            <span>
                                Final Amount
                            </span>

                            <span class="text-indigo-600">
                                ₹<span x-text="finalAmount.toFixed(2)"></span>
                            </span>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Alpine.js Billing Calculation --}}
    <script>

        function registrationForm() {

            return {

                tickets: 1,

                hasWorkshop: false,

                foodPreference: '',

                eventFee: {{ (float) $event->registration_fee }},

                workshopFee: {{ (float) $event->workshop_fee }},

                foodFee: {{ (float) $event->food_fee }},


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

                    return this.eventFeeTotal
                        + this.workshopTotal
                        + this.foodTotal;

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

                    return this.subtotal
                        * this.discountPercentage
                        / 100;

                },


                get finalAmount() {

                    return this.subtotal
                        - this.discountAmount;

                }

            }

        }

    </script>

</x-public-layout>