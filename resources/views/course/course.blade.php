<x-app-layout x-data="{open:false}">
    <x-slot name="header">
        <div class="flex justify-between align-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Courses') }}
            </h2>
            @auth
                @if (Auth::user()->institute)
                    <a href="course/create" id="lik">
                        <x-primary-button @click="open = !open">create course
                        </x-primary-button>
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="relative py-12 min-h-screen">
        <!-- Background Image with Blur and Dark Overlay -->
        <div class="absolute inset-0 -z-10">
            <img src="E-learning.jpg" alt="Background Image"
                class="w-full h-full object-cover opacity-70 blur-md">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <!-- Main Content Area -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <!-- Change text color to white to ensure it's visible on dark background -->
            <h2 class="font-semibold pb-3 text-xl text-white">Courses list</h2>
            <div class="bg-black text-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-3">
                @foreach($courses as $course)
                    <div class="bg-gray-700 rounded-lg py-2 px-4 shadow-md">
                        <a href="{{'course/' . $course->id}}">
                            <h2 class="font-semibold text-xl text-indigo-500">Course: {{$course->level . ' in ' . $course->course_name}}</h2>
                        </a>
                        <p>{{'Faculty of ' . $course->faculty->faculty_name}}</p>
                        <div>
                            <span>{{$course->level}}</span>
                            <span>|</span>
                            <span>{{$course->course_duration}}</span>
                        </div>
                        <p>{{'Institute: ' . $course->faculty->institute->institute_name}}</p>
                    </div>
                @endforeach
            </div>
            @cannot('institute')
            <div class="my-3">
                {{$courses->links()}}
            </div>
            @endcannot
        </div>

        @if (session('status') === 'course-deleted')
            <x-confirm-modal :name="'create'" :content="'The course deleted successfully'">
            </x-confirm-modal>
        @endif
        @if (session('status') === 'application-created')
            <x-confirm-modal :name="'create'" :content="'The application submitted successfully'">
            </x-confirm-modal>
        @endif
    </div>
</x-app-layout>
