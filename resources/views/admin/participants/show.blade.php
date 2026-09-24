<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Participant Details
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <h2 class="text-2xl font-bold text-gray-900">
                    {{ $participant->name }}
                </h2>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <p class="text-xs text-gray-500 uppercase">
                            Email
                        </p>
                        <p class="font-semibold">
                            {{ $participant->email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase">
                            Phone
                        </p>
                        <p class="font-semibold">
                            {{ $participant->phone ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase">
                            Gender
                        </p>
                        <p class="font-semibold">
                            {{ $participant->gender ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase">
                            Course / Department
                        </p>
                        <p class="font-semibold">
                            {{ $participant->course_department }}
                        </p>
                    </div>

                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">
                        Total Registrations
                    </p>

                    <p class="text-3xl font-bold text-indigo-600">
                        {{ $participant->registrations->count() }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">
                        Total Events
                    </p>

                    <p class="text-3xl font-bold text-blue-600">
                        {{ $participant->registrations->pluck('event_id')->unique()->count() }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">
                        Total Amount Paid
                    </p>

                    <p class="text-3xl font-bold text-green-600">
                        ₹{{ number_format(
                            $participant->registrations
                                ->where('payment_status', 'paid')
                                ->sum('final_amount'),
                            2
                        ) }}
                    </p>
                </div>

            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">

                <h3 class="text-lg font-bold mb-4">
                    Registered Events
                </h3>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    Event
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Tickets
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Amount
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Status
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            @forelse($participant->registrations as $registration)

                                <tr>

                                    <td class="px-4 py-3">
                                        {{ $registration->event->title }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $registration->tickets_count }}
                                    </td>

                                    <td class="px-4 py-3">
                                        ₹{{ number_format($registration->final_amount, 2) }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ ucfirst($registration->payment_status) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                        No registrations found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('participants.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md"
                >
                    Back
                </a>

                <a
                    href="{{ route('participants.edit', $participant) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                >
                    Edit Participant
                </a>

            </div>

        </div>

    </div>

</x-app-layout>