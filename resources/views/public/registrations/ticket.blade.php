<x-public-layout>
    <div class="min-h-screen bg-gray-900 py-12 px-4 flex items-center justify-center">
        <div class="max-w-xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-800 relative">
            
            <!-- Top Header Banner -->
            <div class="bg-gradient-to-r from-gray-900 via-indigo-950 to-gray-900 text-white p-6 sm:p-8 text-center relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-600/20 rounded-full blur-2xl"></div>
                
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 uppercase tracking-widest mb-2">
                    Registration #{{ $registration->id }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Event Ticket
                </h1>
            </div>

            <!-- Ticket Body -->
            <div class="p-6 sm:p-8 space-y-6 bg-gray-50/50">

                <!-- Event Title & Date -->
                <div class="text-center border-b border-gray-200 pb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                        {{ $registration->event->title }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-500 font-medium">
                        {{ $registration->event->event_date->format('M d, Y h:i A') }}
                    </p>
                </div>

                <!-- Participant & Payment Info Grid -->
                <div class="grid grid-cols-2 gap-4 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                    <div>
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Participant</span>
                        <span class="text-sm font-bold text-gray-900">{{ $registration->participant->name }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Email</span>
                        <span class="text-sm font-semibold text-gray-700 truncate block">{{ $registration->participant->email }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Tickets</span>
                        <span class="text-sm font-bold text-indigo-600">{{ $registration->tickets_count }} Seats</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Payment</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-extrabold bg-emerald-100 text-emerald-800 uppercase">
                            {{ $registration->payment_status }}
                        </span>
                    </div>
                </div>

                <!-- Barcode / QR Ticket Box with Tear Effect -->
                <div class="relative bg-white border-2 border-dashed border-indigo-200 rounded-2xl p-6 text-center shadow-sm">
                    <!-- Decorative semi-circle notches for ticket stub look -->
                    <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-gray-900 rounded-full"></div>
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-gray-900 rounded-full"></div>

                    <div class="mb-3 flex justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ $registration->ticket_code }}" 
                             alt="Ticket QR Code" 
                             class="w-32 h-32 object-contain bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                    </div>

                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Unique Ticket Code</span>
                    <div class="mt-1 text-lg sm:text-xl font-mono font-black text-indigo-950 tracking-wider">
                        {{ $registration->ticket_code }}
                    </div>
                </div>

                <!-- Final Amount Summary -->
                <div class="bg-white rounded-2xl p-4 flex justify-between items-center shadow-sm border border-gray-100 px-6">
                    <span class="font-semibold text-gray-600">Final Amount</span>
                    <span class="font-black text-indigo-600 text-xl">
                        ₹{{ number_format($registration->final_amount, 2) }}
                    </span>
                </div>

                <!-- Action Button -->
                <button
                    onclick="window.print()"
                    class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-gray-900/20 transition text-center text-sm"
                >
                    Print Ticket
                </button>

            </div>

        </div>
    </div>
</x-public-layout>