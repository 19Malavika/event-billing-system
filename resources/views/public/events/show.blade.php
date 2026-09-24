<x-public-layout>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4">

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <div class="bg-indigo-700 text-white p-8">
                    <div class="flex justify-between items-start gap-4">

                        <div>
                            <h1 class="text-3xl font-bold">
                                {{ $event->title }}
                            </h1>

                            <p class="mt-2 text-indigo-100">
                                {{ $event->event_date->format('M d, Y h:i A') }}
                            </p>
                        </div>

                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                            {{ ucfirst($event->status) }}
                        </span>

                    </div>
                </div>

                <div class="p-8 space-y-8">

                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            About This Event
                        </h2>

                        <p class="mt-3 text-gray-600 leading-relaxed">
                            {{ $event->description ?: 'No description available.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="bg-gray-50 rounded-lg p-5">
                            <p class="text-sm text-gray-500">
                                Registration Period
                            </p>

                            <p class="mt-2 font-semibold text-gray-900">
                                {{ $event->registration_start_date->format('M d, Y h:i A') }}
                                -
                                {{ $event->registration_end_date->format('M d, Y h:i A') }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-5">
                            <p class="text-sm text-gray-500">
                                Available Seats
                            </p>

                            <p class="mt-2 text-2xl font-bold text-indigo-600">
                                {{ $event->available_seats }}
                                <span class="text-sm font-normal text-gray-500">
                                    / {{ $event->total_seats }}
                                </span>
                            </p>
                        </div>

                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            Event Pricing
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                            <div class="border rounded-lg p-4">
                                <p class="text-sm text-gray-500">
                                    Registration
                                </p>
                                <p class="text-xl font-bold">
                                    ₹{{ number_format($event->registration_fee, 2) }}
                                </p>
                            </div>

                            <div class="border rounded-lg p-4">
                                <p class="text-sm text-gray-500">
                                    Workshop
                                </p>
                                <p class="text-xl font-bold">
                                    ₹{{ number_format($event->workshop_fee, 2) }}
                                </p>
                            </div>

                            <div class="border rounded-lg p-4">
                                <p class="text-sm text-gray-500">
                                    Food
                                </p>
                                <p class="text-xl font-bold">
                                    ₹{{ number_format($event->food_fee, 2) }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">

                        <a
                            href="{{ route('public.events.register', $event) }}"
                            class="flex-1 text-center bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700"
                        >
                            Register Now
                        </a>

                        <a
                            href="{{ route('public.events.index') }}"
                            class="text-center bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300"
                        >
                            Back to Events
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>

</x-public-layout>
