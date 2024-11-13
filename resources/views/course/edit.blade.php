<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between align-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Update Course') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        @if (Auth::user()?->institute?->id === $course->faculty->institute->id)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <h2 class="font-semibold pb-3 text-xl">Update {{$course->course_name}}</h2>
            <div class="bg-white overflow-hidden shadow-sm max-[640px]:rounded-lg sm:rounded-lg p-8">
                @include('includes.edit-course')
            </div>
        </div>
        @else
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <h2 class="font-medium">Status code: 403</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                You are unauthorized
            </div>
        </div>
        @endif  
    </div>
</x-app-layout>

