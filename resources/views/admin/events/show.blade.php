<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $event->title }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('events.edit', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">Edit Event</a>
                <a href="{{ route('events.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">Back to List</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                
                <!-- Status & Date Info -->
                <div class="flex items-center justify-between border-b pb-4">
                    <div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-500">
                        Event Date: <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y h:i A') }}</span>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Description</h3>
                    <p class="mt-2 text-gray-600 leading-relaxed">{{ $event->description }}</p>
                </div>

                <!-- Registration Window Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                    <div>
                        <span class="text-sm text-gray-500 block">Registration Start Date</span>
                        <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($event->registration_start_date)->format('M d, Y h:i A') }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500 block">Registration End Date</span>
                        <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($event->registration_end_date)->format('M d, Y h:i A') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>