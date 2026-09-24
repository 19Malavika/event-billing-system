<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Revenue & Billing Report
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Page Description -->
            <div>
                <p class="text-gray-600">
                    View registration revenue, payments, discounts, and billing details.
                </p>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="GET" action="{{ route('reports.revenue') }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

                        <!-- From Date -->
                        <div>
                            <label
                                for="from_date"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                From Date
                            </label>

                            <input
                                type="date"
                                id="from_date"
                                name="from_date"
                                value="{{ request('from_date') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- To Date -->
                        <div>
                            <label
                                for="to_date"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                To Date
                            </label>

                            <input
                                type="date"
                                id="to_date"
                                name="to_date"
                                value="{{ request('to_date') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- Event -->
                        <div>
                            <label
                                for="event_id"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Event
                            </label>

                            <select
                                id="event_id"
                                name="event_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">All Events</option>

                                @foreach($events as $event)
                                    <option
                                        value="{{ $event->id }}"
                                        {{ request('event_id') == $event->id ? 'selected' : '' }}
                                    >
                                        {{ $event->title }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <label
                                for="payment_status"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Payment Status
                            </label>

                            <select
                                id="payment_status"
                                name="payment_status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">All Statuses</option>

                                <option
                                    value="paid"
                                    {{ request('payment_status') === 'paid' ? 'selected' : '' }}
                                >
                                    Paid
                                </option>

                                <option
                                    value="pending"
                                    {{ request('payment_status') === 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="failed"
                                    {{ request('payment_status') === 'failed' ? 'selected' : '' }}
                                >
                                    Failed
                                </option>

                                <option
                                    value="refunded"
                                    {{ request('payment_status') === 'refunded' ? 'selected' : '' }}
                                >
                                    Refunded
                                </option>

                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-end gap-2">

                            <button
                                type="submit"
                                class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700"
                            >
                                Filter
                            </button>

                            <a
                                href="{{ route('reports.revenue') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                            >
                                Reset
                            </a>

                        </div>

                    </div>

                </form>

            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <!-- Total Revenue -->
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">
                        Total Revenue
                    </p>

                    <p class="text-2xl font-bold text-green-600">
                        ₹{{ number_format($totalRevenue ?? 0, 2) }}
                    </p>
                </div>

                <!-- Total Registrations -->
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">
                        Total Registrations
                    </p>

                    <p class="text-2xl font-bold text-indigo-600">
                        {{ $totalRegistrations ?? 0 }}
                    </p>
                </div>

                <!-- Paid -->
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">
                        Paid
                    </p>

                    <p class="text-2xl font-bold text-green-600">
                        {{ $paidCount ?? 0 }}
                    </p>
                </div>

                <!-- Pending -->
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">
                        Pending
                    </p>

                    <p class="text-2xl font-bold text-yellow-600">
                        {{ $pendingCount ?? 0 }}
                    </p>
                </div>

                <!-- Discounts -->
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">
                        Total Discounts
                    </p>

                    <p class="text-2xl font-bold text-purple-600">
                        ₹{{ number_format($totalDiscounts ?? 0, 2) }}
                    </p>
                </div>

            </div>

            <!-- Billing Table -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Billing Details
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    ID
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Participant
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Event
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Subtotal
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Discount %
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Discount Amount
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Final Amount
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Payment Status
                                </th>

                            </tr>

                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse($registrations as $reg)

                                <tr>

                                    <!-- ID -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        #{{ $reg->id }}
                                    </td>

                                    <!-- Participant -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $reg->participant->name ?? 'N/A' }}
                                    </td>

                                    <!-- Event -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $reg->event->title ?? 'N/A' }}
                                    </td>

                                    <!-- Subtotal -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        ₹{{ number_format($reg->subtotal, 2) }}
                                    </td>

                                    <!-- Discount % -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ number_format($reg->discount_percentage, 2) }}%
                                    </td>

                                    <!-- Discount Amount -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        ₹{{ number_format($reg->discount_amount, 2) }}
                                    </td>

                                    <!-- Final Amount -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        ₹{{ number_format($reg->final_amount, 2) }}
                                    </td>

                                    <!-- Payment Status -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">

                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $reg->payment_status === 'paid'
                                                ? 'bg-green-100 text-green-800'
                                                : ($reg->payment_status === 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800') }}"
                                        >
                                            {{ ucfirst($reg->payment_status) }}
                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="px-6 py-8 text-center text-gray-500"
                                    >
                                        No billing records found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                <div class="p-6">
                    {{ $registrations->links() }}
                </div>

            </div>

        </div>

    </div>

</x-app-layout>