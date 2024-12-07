<x-app-layout x-data="{ open: false }">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Course') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <h2 class="font-semibold pb-3 text-xl text-gray-700">New Course</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 border border-gray-200">
                <form method="POST" action="{{ route('course.store') }}">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="course_name" class="block text-sm font-medium text-gray-700">Course Name</label>
                        <input id="course_name" name="course_name" type="text" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('course_name') }}" required />
                    </div>

                    <div class="form-group mb-4">
                        <label for="course_code" class="block text-sm font-medium text-gray-700">Course Code</label>
                        <input id="course_code" name="course_code" type="text" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('course_code') }}" required />
                    </div>

                    <div class="form-group mb-4">
                        <label for="course_duration" class="block text-sm font-medium text-gray-700">Course Duration</label>
                        <input id="course_duration" name="course_duration" type="text" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('course_duration') }}" required />
                    </div>

                    <div class="form-group mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input id="price" name="price" type="text" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('price') }}" required />
                    </div>

                    <div class="form-group mb-4">
                        <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
                        <input id="level" name="level" type="text" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('level') }}" required />
                    </div>

                    <div class="form-group mb-4">
                        <label for="faculty" class="block text-sm font-medium text-gray-700">Faculty</label>
                        <select id="faculty" name="faculty" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="" disabled selected>Select Faculty</option>
                            @if($faculties && $faculties->isNotEmpty())
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ old('faculty') == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->faculty_name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>No faculties available</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" rows="4" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements</label>
                        <textarea id="requirements" name="requirements" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" rows="4" required>{{ old('requirements') }}</textarea>
                    </div>

                    <div class="form-group mb-4">
                        <button type="submit" class="btn btn-primary py-2 px-4 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Create Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
