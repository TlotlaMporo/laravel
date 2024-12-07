<x-app-layout x-data="{open:false}">
    <x-slot name="header">
        <div class="flex justify-between align-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Applications') }}
            </h2>
 @can('institute')
            <form method="POST" action="/control/{{Auth::user()->institute->id}}">
        @csrf
        @method("PATCH")
        @if (isset($applications[1]) && is_countable($applications[1]) && count($applications[1]) > 0)
            <x-primary-button class="bg-green-500" name="action" value="admission">
                {{ (Auth::user()->institute->control->admissions !== 'open') ? 'Publish Admissions' : 'Published' }}
            </x-primary-button>
        @endif
        <x-primary-button class="bg-green-500" name="action" value="application">
            {{ (Auth::user()->institute->control->applications !== 'open') ? 'Open Applications' : 'Close Applications' }}
        </x-primary-button>
    </form>
@endcan

        </div>
    </x-slot>

    <div class="py-12 min-h-screen bg-cover bg-center" style="background-image: url('applications.jpeg');">
        <!-- Apply a blurred overlay -->
        <div class="absolute inset-0 bg-black opacity-50 backdrop-blur-lg"></div> <!-- Blurred overlay -->

        <div class="relative z-10">
            @can('institute')
                @foreach(['Pending', 'Admitted', 'Waitlisted', 'Rejected'] as $statusKey => $status)
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <h2 class="font-semibold pb-3 text-xl text-white">{{ $status }} Applications</h2>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-3 text-white">
                            @foreach($applications[$statusKey] as $application)
                                <div class="bg-gray-700 fr-1 rounded-lg py-2 px-4 shadow-md">
                                    <a href="{{ '/applications/' . $application->id }}">
                                        <h2 class="font-semibold text-xl text-indigo-500">Course: {{ $application->course->course_name }}</h2>
                                        <p>{{ 'Faculty of ' . $application->course->faculty->faculty_name }}</p>
                                        <p>{{ 'Institute: ' . $application->course->faculty->institute->institute_name }}</p>
                                        <span>{{ "Application date: $application->created_at" }}</span>
                                        @if($status == 'Admitted')
                                            <span class="block">{{ "Admitted date: $application->updated_at" }}</span>
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endcan

            @can('student')
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <h2 class="font-semibold pb-3 text-xl text-white">Your Applications</h2>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-3 text-white">
                        @if($applications && $applications->isNotEmpty())
                            @foreach($applications as $application)
                                <div class="bg-gray-700 fr-1 rounded-lg py-2 px-4 shadow-md">
                                    <a href="{{ '/applications/' . $application->id }}">
                                        <h2 class="font-semibold text-xl text-indigo-500">Course: {{ $application->course->course_name }}</h2>
                                        <p>{{ 'Faculty of ' . $application->course->faculty->faculty_name }}</p>
                                        <p>{{ 'Institute: ' . $application->course->faculty->institute->institute_name }}</p>
                                        <span>{{ "Application date: $application->created_at" }}</span>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-white">No applications found.</p>
                        @endif
                    </div>
                </div>
            @endcan

            @if (session('status') === 'application-created')
                <x-confirm-modal :name="'create'" :content="'The application submitted successfully'"></x-confirm-modal>
            @endif
        </div>
    </div>
</x-app-layout>
