<x-admin-layout>
    <div class="py-12" x-data="{name:''}">
        <div class="flex justify-between items-center mb-3 sm:px-8">
            <h2 id="title" data-title="Faculty" data-list="Faculties" class="font-bold">New Faculty</h2>
            <x-primary-button id="faculty">show Faculties
            </x-primary-button>
        </div>
        <div id="faculty-form" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form method="POST" action="{{ route('create-faculty') }}">
                    @csrf
                    <div>
                        <x-input-label for="institute" :value="__('Institute')" />
                        <select id="institute" class=" mt-1 w-full border-gray-300 rounded-md" name="institute"
                                required>
                            <option value="">Select institute</option>
                            @foreach ($institutes as $institute)
                                <option value="{{$institute->id}}">{{$institute->institute_name}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('institute')" class="mt-2" />
                    </div>
                    <!-- faculty field -->
                    <div>
                        <x-input-label for="faculty_name" :value="__('Faculty name')" />
                        <x-text-input id="faculty_name" class="block mt-1 w-full" type="text" name="faculty_name"
                            :value="old('faculty_name')" required autofocus />
                    </div>
                    <div>
                        <x-primary-button class="mt-3">
                            {{__('Add faculty')}}
                        </x-primary-button>
                    </div>
                    <x-input-error :messages="$errors->get('faculty_name')" class="mt-2" />



                </form>
            </div>
        </div>
        <div id="faculty-list" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="w-full p-2">
                <thead>
                    <tr class="bg-slate-500">
                        <th class="text-start px-3 py-2">Id</th>
                        <th class="text-start">Faculty name</th>
                        <th class="text-start">Institute</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($faculties); $i++)
                        <tr class="{{$i % 2 === 0 ? 'bg-gray-200' : 'bg-gray-400'}}">
                            <td class="px-3 py-3">{{$faculties[$i]->id}}</td>
                            <td>{{$faculties[$i]->faculty_name}}</td>
                            <td>{{$faculties[$i]->institute->institute_name}}</td>
                            <td class="text-center">
                                <a href="{{'/ad/faculty/'.$faculties[$i]->id}}/edit">
                                  <x-primary-button>edit
                                </x-primary-button>  
                                </a>
                                
                                <x-danger-button id="delete" data-faculty-id="{{$faculties[$i]->id}}">delete</x-danger-button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <form method="POST" id="delete-form" action="" class="hidden">
                @csrf
                @method("DELETE")
            </form>
            <div class="mt-3">{{$faculties->links()}}</div>
        </div>
    </div>
    
</x-admin-layout>