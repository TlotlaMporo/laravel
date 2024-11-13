<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold pb-3 text-xl">Your Stats</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-3 text-white">
                @can('institute')
                    <x-dashboard-card title="Faculties">
                        {{ Auth::user()?->institute?->faculty ? count(Auth::user()->institute->faculty) : 0 }}
                    </x-dashboard-card>
                    <x-dashboard-card title="Courses">
                        {{ count($courses ?? []) }}
                    </x-dashboard-card>
                    <x-dashboard-card title="Applications">
                        {{ count($applications ?? []) }}
                    </x-dashboard-card>
                    <x-dashboard-card title="Admissions">
                        {{ count($admissions ?? []) }}
                    </x-dashboard-card>
                @endcan
                
                @can('student')
                    <x-dashboard-card title="Applications">
                        {{ count(Auth::user()?->student?->application ?? []) }}
                    </x-dashboard-card>
                    <x-dashboard-card title="Courses you applied for">
                        {{ count(Auth::user()?->student?->application ?? []) }}
                    </x-dashboard-card>
                    <x-dashboard-card title="Institutes">
                        {{ count($student_institutes ?? []) }}
                    </x-dashboard-card>
                @endcan
            </div>
        </div> 
    </div>
</x-app-layout>
