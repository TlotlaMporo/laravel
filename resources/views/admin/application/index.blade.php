<x-admin-layout x-data="{open:false}">
    
    <div class="py-12">
        <div name="header">
            <div class="flex justify-between align-center mb-3 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                    {{ __('Applications') }}
                </h2>
        </div>
        </div>
        @can('admin')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="font-semibold pb-3 text-xl">Pending Applications</h2>
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid md:grid-cols-3 sm:grid-cols-2 gap-3 text-white">
                    @forelse($applications[0] as $application) 

                        <div class="bg-gray-700 fr-1 rounded-lg py-2 px-4 shadow-md">
                            <a href="/ad/applications/{{$application->id}}">
                                <h2 class="font-semibold text-xl text-indigo-500">Course:
                                    {{$application->course->course_name}}
                                </h2>

                                <p>{{'Faculty of ' . $application->course->faculty->faculty_name}}</p>
                                <p>{{'Institute: ' . $application->course->faculty->institute->institute_name}}</p>
                                <span>{{"Application date: $application->created_at"}}</span>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-600">
                          No data just yet  
                        </p>  
                    @endforelse
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="font-semibold pb-3 text-xl">Admitted Applications</h2>
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid md:grid-cols-3 sm:grid-cols-2 gap-3 text-white">
                    @forelse($applications[1] as $application) 

                        <div class="bg-gray-700 fr-1 rounded-lg py-2 px-4 shadow-md">
                            <a href="/ad/applications/{{$application->id}}">
                                <h2 class="font-semibold text-xl text-indigo-500">Course:
                                    {{$application->course->course_name}}
                                </h2>

                                <p>{{'Faculty of ' . $application->course->faculty->faculty_name}}</p>
                                <p>{{'Institute: ' . $application->course->faculty->institute->institute_name}}</p>
                                <span>{{"Application date: $application->created_at"}}</span>
                                <span class="block">{{"Admitted date: $application->updated_at"}}</span>
                            </a>
                        </div>
                        @empty
                        <p class="text-gray-600">
                          No data just yet  
                        </p>  
                    @endforelse
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="font-semibold pb-3 text-xl">Waitlisted Applications</h2>
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid md:grid-cols-3 sm:grid-cols-2 gap-3 text-white">
                    @forelse($applications[2] as $application) 

                        <div class="bg-gray-700 fr-1 rounded-lg py-2 px-4 shadow-md">
                            <a href="/ad/applications/{{$application->id}}">
                                <h2 class="font-semibold text-xl text-indigo-500">Course:
                                    {{$application->course->course_name}}
                                </h2>

                                <p>{{'Faculty of ' . $application->course->faculty->faculty_name}}</p>
                                <p>{{'Institute: ' . $application->course->faculty->institute->institute_name}}</p>
                                <span>{{"Application date: $application->created_at"}}</span>
                                <span>{{"Waitlisted date: $application->updated_at"}}</span>
                            </a>
                        </div>
                        @empty
                        <p class="text-gray-600">
                          No data just yet  
                        </p>  
                    @endforelse
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="font-semibold pb-3 text-xl">Rejected Applications</h2>
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid md:grid-cols-3 sm:grid-cols-2 gap-3 text-white">
                    @forelse($applications[3] as $application) 

                        <div class="bg-gray-700 fr-1 rounded-lg py-2 px-4 shadow-md">
                            <a href="/ad/applications/{{$application->id}}">
                                <h2 class="font-semibold text-xl text-indigo-500">Course:
                                    {{$application->course->course_name}}
                                </h2>

                                <p>{{'Faculty of ' . $application->course->faculty->faculty_name}}</p>
                                <p>{{'Institute: ' . $application->course->faculty->institute->institute_name}}</p>
                                <span>{{"Application date: $application->created_at"}}</span>
                                <span>{{"Rejected date: $application->updated_at"}}</span>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-600">
                          No data just yet  
                        </p>  
                    @endforelse
                </div>
            </div>
        @endcan
    </div>
</x-admin-layout>