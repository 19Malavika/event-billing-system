<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Edit Participant: ') }} {{ $participant->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 border border-slate-700 overflow-hidden shadow-lg sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 bg-red-900/40 border border-red-700 text-red-200 px-4 py-3 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('participants.update', $participant) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Full Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Full Name</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $participant->name) }}"
                               class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required>
                    </div>

                    {{-- Email + Phone --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300">Email Address</label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email', $participant->email) }}"
                                   class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   required>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-300">Phone Number</label>
                            <input type="text" name="phone" id="phone"
                                   value="{{ old('phone', $participant->phone) }}"
                                   class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    {{-- Course + Gender --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="course_department" class="block text-sm font-medium text-gray-300">Course / Department</label>
                            <input type="text" name="course_department" id="course_department"
                                   value="{{ old('course_department', $participant->course_department) }}"
                                   class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   required>
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-300">Gender</label>
                            <select name="gender" id="gender"
                                    class="mt-1 block w-full rounded-md bg-slate-900 border-slate-600 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" class="bg-slate-900">Select Gender</option>
                                <option value="Male"   class="bg-slate-900" {{ old('gender', $participant->gender) == 'Male'   ? 'selected' : '' }}>Male</option>
                                <option value="Female" class="bg-slate-900" {{ old('gender', $participant->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other"  class="bg-slate-900" {{ old('gender', $participant->gender) == 'Other'  ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end space-x-3 pt-2">
                        <a href="{{ route('participants.index') }}"
                           class="bg-slate-700 text-gray-200 px-4 py-2 rounded-md text-sm hover:bg-slate-600 transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700 transition">
                            Update Participant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>