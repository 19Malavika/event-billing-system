<x-app-layout>
    <div class="py-12" x-data="{
        ticketCount: 1,
        ticketPrice: {{ $event->registration_fee }},
        workshopIncluded: false,
        workshopFee: 50.00,
        foodIncluded: false,
        foodFee: 30.00,
        discountPercent: 10,
        
        get subtotal() {
            let total = (this.ticketCount * this.ticketPrice);
            if (this.workshopIncluded) total += this.workshopFee;
            if (this.foodIncluded) total += this.foodFee;
            return total;
        },
        get discountAmount() {
            return (this.subtotal * this.discountPercent) / 100;
        },
        get finalAmount() {
            return this.subtotal - this.discountAmount;
        }
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Register for: {{ $event->title }}</h2>

                <form action="{{ route('events.register.store', $event->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Participant Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Course / Department</label>
                            <input type="text" name="course_department" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <!-- Options -->
                 <div class="border-t pt-4 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Number of Tickets</label>
        <input type="number" 
               name="ticket_count" 
               x-model.number="ticketCount" 
               min="1" 
               max="10" 
               step="1"
               class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm">
    </div>
    <div class="flex items-center space-x-4">
        <label class="flex items-center">
            <input type="checkbox" name="workshop_included" x-model="workshopIncluded" class="rounded border-gray-300 text-indigo-600 shadow-sm">
            <span class="ml-2 text-sm text-gray-700">Include Workshop (+₹50.00)</span>
        </label>
        <label class="flex items-center">
            <input type="checkbox" name="food_included" x-model="foodIncluded" class="rounded border-gray-300 text-indigo-600 shadow-sm">
            <span class="ml-2 text-sm text-gray-700">Include Food Package (+₹30.00)</span>
        </label>
    </div>
</div>   
                    <!-- Dynamic Billing Summary Box -->
                    <div class="bg-gray-50 p-4 rounded-lg space-y-2 border">
                        <h3 class="font-semibold text-gray-800">Billing Summary</h3>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal:</span>
                            <span>₹<span x-text="subtotal.toFixed(2)"></span></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Discount (10%):</span>
                            <span>-₹<span x-text="discountAmount.toFixed(2)"></span></span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-gray-900 border-t pt-2">
                            <span>Final Amount:</span>
                            <span>₹<span x-text="finalAmount.toFixed(2)"></span></span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 font-semibold">
                        Confirm & Complete Registration
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>