<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Revenue & Billing Report</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-bold text-green-600">₹{{ $totalRevenue ?? 0 }}</p>
                </div>
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">Paid Registrations</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $paidCount ?? 0 }}</p>
                </div>
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">Pending Payments</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount ?? 0 }}</p>
                </div>
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">Total Discounts Given</p>
                    <p class="text-2xl font-bold text-indigo-600">₹{{ $totalDiscounts ?? 0 }}</p>
                </div>
            </div>

            <!-- Billing Table -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Participant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Final Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($registrations ?? [] as $reg)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">#{{ $reg->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $reg->participant->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $reg->event->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">₹{{ $reg->final_amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 text-xs rounded {{ $reg->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($reg->payment_status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>