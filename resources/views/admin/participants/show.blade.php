<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100">
            Participant Details
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-900 min-h-screen">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Profile Card --}}
            <div class="bg-slate-800 border border-slate-700 shadow-lg rounded-lg p-6">

                <h2 class="text-2xl font-bold text-gray-100">
                    {{ $participant->name }}
                </h2>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Email</p>
                        <p class="font-semibold text-gray-100">{{ $participant->email }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Phone</p>
                        <p class="font-semibold text-gray-100">{{ $participant->phone ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Gender</p>
                        <p class="font-semibold text-gray-100">{{ $participant->gender ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Course / Department</p>
                        <p class="font-semibold text-gray-100">{{ $participant->course_department }}</p>
                    </div>

                </div>

            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="bg-slate-800 border border-slate-700 shadow-lg rounded-lg p-6">
                    <p class="text-sm text-gray-400">Total Registrations</p>
                    <p class="text-3xl font-bold text-indigo-400">
                        {{ $participant->registrations->count() }}
                    </p>
                </div>

                <div class="bg-slate-800 border border-slate-700 shadow-lg rounded-lg p-6">
                    <p class="text-sm text-gray-400">Total Events</p>
                    <p class="text-3xl font-bold text-blue-400">
                        {{ $participant->registrations->pluck('event_id')->unique()->count() }}
                    </p>
                </div>

                <div class="bg-slate-800 border border-slate-700 shadow-lg rounded-lg p-6">
                    <p class="text-sm text-gray-400">Total Amount Paid</p>
                    <p class="text-3xl font-bold text-green-400">
                        ₹{{ number_format(
                            $participant->registrations
                                ->where('payment_status', 'paid')
                                ->sum('final_amount'),
                            2
                        ) }}
                    </p>
                </div>

            </div>

            {{-- Registered Events --}}
            <div class="bg-slate-800 border border-slate-700 shadow-lg rounded-lg p-6">

                <h3 class="text-lg font-bold mb-4 text-gray-100">Registered Events</h3>

                <div class="overflow-x-auto rounded-lg border border-slate-700">

                    <table class="min-w-full divide-y divide-slate-700">

                        <thead class="bg-slate-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Event</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tickets</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>

                        <tbody class="bg-slate-800 divide-y divide-slate-700">

                            @forelse($participant->registrations as $registration)

                                <tr class="hover:bg-slate-700/50 transition">
                                    <td class="px-4 py-3 text-sm text-gray-100">{{ $registration->event->title }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-300">{{ $registration->tickets_count }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-300">₹{{ number_format($registration->final_amount, 2) }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @php
                                            $statusColors = [
                                                'paid'     => 'bg-green-900/50 text-green-300 border-green-700',
                                                'pending'  => 'bg-yellow-900/50 text-yellow-300 border-yellow-700',
                                                'failed'   => 'bg-red-900/50 text-red-300 border-red-700',
                                                'refunded' => 'bg-slate-700 text-gray-300 border-slate-600',
                                            ];
                                            $color = $statusColors[$registration->payment_status] ?? 'bg-slate-700 text-gray-300 border-slate-600';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $color }}">
                                            {{ ucfirst($registration->payment_status) }}
                                        </span>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-400">
                                        No registrations found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3">

                <a href="{{ route('participants.index') }}"
                   class="px-4 py-2 bg-slate-700 text-gray-200 rounded-md text-sm hover:bg-slate-600 transition">
                    Back
                </a>

                <a href="{{ route('participants.edit', $participant) }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition">
                    Edit Participant
                </a>

            </div>

        </div>

    </div>

</x-app-layout>