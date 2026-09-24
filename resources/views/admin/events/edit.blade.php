<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Event
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('events.update', $event) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Event Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $event->title) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Event Date & Time
                            </label>

                            <input
                                type="datetime-local"
                                name="event_date"
                                value="{{ old('event_date', $event->event_date?->format('Y-m-d\TH:i')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Total Seats
                            </label>

                            <input
                                type="number"
                                name="total_seats"
                                min="1"
                                value="{{ old('total_seats', $event->total_seats) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >

                            <p class="mt-1 text-xs text-gray-500">
                                Currently registered:
                                {{ $event->total_seats - $event->available_seats }}
                            </p>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Registration Fee
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="registration_fee"
                                value="{{ old('registration_fee', $event->registration_fee) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Workshop Fee
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="workshop_fee"
                                value="{{ old('workshop_fee', $event->workshop_fee) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Food Fee
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="food_fee"
                                value="{{ old('food_fee', $event->food_fee) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Registration Start
                            </label>

                            <input
                                type="datetime-local"
                                name="registration_start_date"
                                value="{{ old('registration_start_date', $event->registration_start_date?->format('Y-m-d\TH:i')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Registration End
                            </label>

                            <input
                                type="datetime-local"
                                name="registration_end_date"
                                value="{{ old('registration_end_date', $event->registration_end_date?->format('Y-m-d\TH:i')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                        </div>

                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Status
                        </label>

                        <select
                            name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            required
                        >
                            @foreach(['draft', 'published', 'completed', 'cancelled'] as $status)
                                <option
                                    value="{{ $status }}"
                                    @selected(old('status', $event->status) === $status)
                                >
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a
                            href="{{ route('events.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                        >
                            Update Event
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>