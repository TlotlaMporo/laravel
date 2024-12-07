<x-app-layout x-data="{ open: false }">
    <x-slot name="header">
        <div class="flex justify-between align-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Courses') }}
            </h2>
            @auth
                @if (Auth::user()->institute)
                    <a href="{{ route('course.create') }}" id="lik">
                        <x-primary-button @click="open = !open">Create Course</x-primary-button>
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="relative py-12 min-h-screen">
        <!-- Background Image with Blur and Dark Overlay -->
        <div class="absolute inset-0 -z-10">
            <img src="E-learning.jpg" alt="Background Image" class="w-full h-full object-cover opacity-70 blur-md">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <!-- Main Content Area -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <h2 class="font-semibold pb-3 text-xl text-white">Courses List</h2>
            <div class="bg-black text-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-3">
                @foreach($courses as $course)
                    <div class="bg-gray-700 rounded-lg py-2 px-4 shadow-md">
                        <a href="{{ route('course.show', $course->id) }}">
                            <h2 class="font-semibold text-xl text-indigo-500">Course: {{ $course->level . ' in ' . $course->course_name }}</h2>
                        </a>
                        <p>{{ 'Faculty of ' . $course->faculty->faculty_name }}</p>
                        <div>
                            <span>{{ $course->level }}</span>
                            <span>|</span>
                            <span>{{ $course->course_duration }}</span>
                        </div>
                        <p>{{ 'Institute: ' . $course->faculty->institute->institute_name }}</p>

                        <!-- Apply Now Button for students -->
                        @cannot('institute')
                        <a href="{{ route('application.create', $course->id) }}" class="mt-2">
                                 <x-primary-button>Apply Now</x-primary-button>
                        </a>

                        @endcannot
                    </div>
                @endforeach
            </div>

            @cannot('institute')
                <div class="my-3">
                    {{ $courses->links() }}
                </div>
            @endcannot
        </div>

        <!-- Confirmation Modals -->
        @if (session('status') === 'course-deleted')
            <x-confirm-modal :name="'delete-course'" :content="'The course was deleted successfully.'">
            </x-confirm-modal>
        @endif
        @if (session('status') === 'application-created')
            <x-confirm-modal :name="'apply-course'" :content="'The application was submitted successfully.'">
            </x-confirm-modal>
        @endif
    </div>
</x-app-layout>
