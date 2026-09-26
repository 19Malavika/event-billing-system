<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Revenue & Billing Report
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Page Description -->
            <div>
                <p class="text-gray-400">
                    View registration revenue, payments, discounts, and billing details.
                </p>
            </div>

            <!-- Filters -->
            <div class="bg-slate-800 border border-slate-700 shadow-lg rounded-lg p-6">

                <form method="GET" action="{{ route('reports.revenue') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

                        <!-- From Date -->
                        <div>
                            <label for="from_date" class="block text-sm font-medium text-gray-300 mb-1">
                                From Date
                            </label>
                            <input type="date" id="from_date" name="from_date"
                                   value="{{ request('from_date') }}"
                                   class="w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 [color-scheme:dark]">
                        </div>

                        <!-- To Date -->
                        <div>
                            <label for="to_date" class="block text-sm font-medium text-gray-300 mb-1">
                                To Date
                            </label>
                            <input type="date" id="to_date" name="to_date"
                                   value="{{ request('to_date') }}"
                                   class="w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 [color-scheme:dark]">
                        </div>

                        <!-- Event -->
                        <div>
                            <label for="event_id" class="block text-sm font-medium text-gray-300 mb-1">
                                Event
                            </label>
                            <select id="event_id" name="event_id"
                                    class="w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" class="bg-slate-900">All Events</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" class="bg-slate-900"
                                            {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                        {{ $event->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-300 mb-1">
                                Payment Status
                            </label>
                            <select id="payment_status" name="payment_status"
                                    class="w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value=""        class="bg-slate-900">All Statuses</option>
                                <option value="paid"     class="bg-slate-900" {{ request('payment_status') === 'paid'     ? 'selected' : '' }}>Paid</option>
                                <option value="pending"  class="bg-slate-900" {{ request('payment_status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                                <option value="failed"   class="bg-slate-900" {{ request('payment_status') === 'failed'   ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" class="bg-slate-900" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                    class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                                Filter
                            </button>
                            <a href="{{ route('reports.revenue') }}"
                               class="px-4 py-2 bg-slate-800 border border-slate-600 text-gray-300 rounded-md hover:bg-slate-700 transition">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>

            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <!-- Total Revenue -->
                <div class="bg-slate-800 border border-slate-700 p-6 shadow-lg rounded-lg">
                    <p class="text-sm text-gray-400">Total Revenue</p>
                    <p class="text-2xl font-bold text-green-400">
                        ₹{{ number_format($totalRevenue ?? 0, 2) }}
                    </p>
                </div>

                <!-- Total Registrations -->
                <div class="bg-slate-800 border border-slate-700 p-6 shadow-lg rounded-lg">
                    <p class="text-sm text-gray-400">Total Registrations</p>
                    <p class="text-2xl font-bold text-indigo-400">
                        {{ $totalRegistrations ?? 0 }}
                    </p>
                </div>

                <!-- Paid -->
                <div class="bg-slate-800 border border-slate-700 p-6 shadow-lg rounded-lg">
                    <p class="text-sm text-gray-400">Paid</p>
                    <p class="text-2xl font-bold text-green-400">
                        {{ $paidCount ?? 0 }}
                    </p>
                </div>

                <!-- Pending -->
                <div class="bg-slate-800 border border-slate-700 p-6 shadow-lg rounded-lg">
                    <p class="text-sm text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-yellow-400">
                        {{ $pendingCount ?? 0 }}
                    </p>
                </div>

                <!-- Discounts -->
                <div class="bg-slate-800 border border-slate-700 p-6 shadow-lg rounded-lg">
                    <p class="text-sm text-gray-400">Total Discounts</p>
                    <p class="text-2xl font-bold text-purple-400">
                        ₹{{ number_format($totalDiscounts ?? 0, 2) }}
                    </p>
                </div>

            </div>

            <!-- Billing Table -->
            <div class="bg-slate-800 border border-slate-700 shadow-lg sm:rounded-lg overflow-hidden">

                <div class="p-6 border-b border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-100">
                        Billing Details
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700">

                        <thead class="bg-slate-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Participant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Discount %</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Discount Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Final Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Payment Status</th>
                            </tr>
                        </thead>

                        <tbody class="bg-slate-800 divide-y divide-slate-700">

                            @forelse($registrations as $reg)
                                <tr class="hover:bg-slate-700/50 transition">

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        #{{ $reg->id }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        {{ $reg->participant->name ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        {{ $reg->event->title ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        ₹{{ number_format($reg->subtotal, 2) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ number_format($reg->discount_percentage, 2) }}%
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        ₹{{ number_format($reg->discount_amount, 2) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-400">
                                        ₹{{ number_format($reg->final_amount, 2) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full border
                                            {{ $reg->payment_status === 'paid'
                                                ? 'bg-green-900/50 text-green-300 border-green-700'
                                                : ($reg->payment_status === 'pending'
                                                    ? 'bg-yellow-900/50 text-yellow-300 border-yellow-700'
                                                    : 'bg-red-900/50 text-red-300 border-red-700') }}">
                                            {{ ucfirst($reg->payment_status) }}
                                        </span>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                        No billing records found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-slate-700">
                    {{ $registrations->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>