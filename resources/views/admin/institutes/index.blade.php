<x-admin-layout>
    <div class="py-12" x-data="{name:''}">
        <div class="flex justify-between items-center mb-3 sm:px-8">
            <h2 id="title" data-title="Institute" data-list="Institutes" class="font-bold">New Institute</h2>
            <x-primary-button id="faculty">show Institutes
            </x-primary-button>
        </div>
        <div id="faculty-form" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6"> 
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                @include('includes.institute-form')
            </div>
        </div>
        <div id="faculty-list" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="w-full p-2">
                <thead>
                    <tr class="bg-slate-500">
                        <th class="text-start px-3 py-2">Id</th>
                        <th class="text-start">Institute name</th>
                        <th class="text-start">Faculties</th>
                        <th class="text-start">Courses</th>
                        <th class="text-start">Application Status</th>
                        <th class="text-start">Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($institutes); $i++)
                        <tr class="{{$i % 2 === 0 ? 'bg-gray-200' : 'bg-gray-400'}}">
                            <td class="px-3 py-3">{{$institutes[$i]->id}}</td>
                            <td>
                                <a class="hover:underline" href="/ad/institute/{{$institutes[$i]->id}}">
                                    {{$institutes[$i]->institute_name}}
                                </a>
                            </td>
                            <td>{{count($institutes[$i]->faculty)}}</td>
                            <td>{{$courses_count[$i]}}</td>
                            <td class="{{($institutes[$i]->control->applications==='open') ? 'text-green-700':'text-red-500'}}">{{$institutes[$i]->control->applications}}</td>
                            <td>{{$institutes[$i]->location}}</td>
                            <td class="text-center">
                                <x-danger-button data-id="{{$institutes[$i]->id}}" id="delete-institute">delete
                                </x-danger-button>
                            </td>
                            
                        </tr>
                    @endfor
                </tbody>
            </table>
            <form id="delete-form" method="POST" action="" class="hidden">
                @csrf
                @method("DELETE")
            </form>
            <div class="mt-3">{{$institutes->links()}}</div>
        </div>
    </div>
    
</x-admin-layout>