<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Participant List') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-slate-800 border border-slate-700 overflow-hidden shadow-lg sm:rounded-lg p-6">

                {{-- Search & Add Actions --}}
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <form method="GET" action="{{ route('participants.index') }}" class="flex gap-2 w-full sm:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search name, email, department..."
                               class="bg-slate-900 border-slate-600 text-gray-100 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm w-full sm:w-80">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700 transition">
                            Search
                        </button>
                    </form>
                    <a href="{{ route('participants.create') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-green-700 transition w-full sm:w-auto text-center">
                        + Add Participant
                    </a>
                </div>

                {{-- Participants Table --}}
                <div class="overflow-x-auto rounded-lg border border-slate-700">
                    <table class="min-w-full divide-y divide-slate-700">
                        <thead class="bg-slate-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Course / Dept</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total Events</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-slate-800 divide-y divide-slate-700">
                            @forelse($participants as $participant)
                                <tr class="hover:bg-slate-700/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-100">{{ $participant->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $participant->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $participant->phone ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $participant->course_department }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $participant->registrations_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('participants.show', $participant) }}"
                                           class="text-indigo-400 hover:text-indigo-300 transition">View</a>
                                        <a href="{{ route('participants.edit', $participant) }}"
                                           class="text-yellow-400 hover:text-yellow-300 transition">Edit</a>
                                        <form action="{{ route('participants.destroy', $participant) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-400 hover:text-red-300 transition"
                                                    onclick="return confirm('Are you sure you want to delete this participant?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-400">No participants found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $participants->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>