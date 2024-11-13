
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faculty') }}
        </h2>
    </x-slot>

    @if (Auth::user()?->institute)
    <div class="py-12" x-data="{name:''}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <h2 class="font-medium">New Faculty</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form method="POST" action="{{ route('create-faculty') }}">
                    @csrf
                
                    <!-- faculty field -->
                    <div>
                        <x-input-label for="faculty_name" :value="__('Faculty name')" />
                            <x-text-input id="faculty_name" class="block mt-1 w-full" 
                            type="text" name="faculty_name" :value="old('faculty_name')" required
                                autofocus />
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2>Faculty List</h2>
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-3 text-white">
                @if ($faculties)
                    @foreach($faculties as $faculty) 
                        <div class="bg-gray-700 fr-1 rounded-lg py-2 px-4 shadow-md space-y-6">
                            <h2 class="font-semibold text-xl text-indigo-500">Faculty: {{$faculty->faculty_name}}
                            </h2>
                            <div>
                                <a href="{{'faculty/' . $faculty->id . '/edit'}}">
                                    <x-primary-button>Edit
                                    </x-primary-button>
                                </a> 
                                <x-danger-button id="delete" data-faculty-id="{{$faculty->id}}">delete</x-danger-button>
                            </div>
                        </div>
                        <form method="POST" id="delete-form" action="{{ 'faculty/' . $faculty->id }}" class="hidden">
                            @csrf
                            @method("DELETE")
                        </form>
                    @endforeach
                @else
                <p class="font-semibold text-xl text-gray-500">No faculty just yet</p>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="py-12" x-data="{name:''}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <h2 class="font-medium">Status code: 403</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                You are unauthorized
            </div>
        </div>               
    </div>
    @endif
</x-app-layout>
