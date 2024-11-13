<x-admin-layout x-data="{open:false}">
    <div class="py-12">
        <div name="header">
            <div class="flex justify-between align-center mb-3">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                    {{ __('Admissions') }}
                </h2>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold pb-3 text-xl">Admissions list</h2>
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid md:grid-cols-3 sm:grid-cols-2 gap-3 text-white">
                @forelse($admissions as $admission) 
                    <div class="bg-gray-700 fr-1 rounded-lg py-2 px-4 shadow-md">
                        <h2 class="font-semibold text-xl text-indigo-500">
                            Student: {{$admission->application->student->full_name}}
                        </h2>
                        <p>Course:
                            {{$admission->application->course->course_name}}
                        </p>
                        <p>{{'Faculty of ' . $admission->application->course->faculty->faculty_name}}</p>
                        <p>{{'Institute: ' . $admission->application->course->faculty->institute->institute_name}}</p>
                        <span>{{"Admission date: " . $admission->created_at}}</span>
                    </div>
                @empty
                    <p class="text-gray-600">
                        No data just yet  
                    </p> 
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>