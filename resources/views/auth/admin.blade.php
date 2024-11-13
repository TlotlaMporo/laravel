<x-admin-layout>
    <div class="py-12" x-data="{name:''}">
        <div class="flex justify-between items-center mb-3 sm:px-8">
            <h2 id="title" data-title="Admin" data-list="Admins" class="font-bold">New Admin</h2>
            <x-primary-button id="faculty">show Admins
            </x-primary-button>
        </div>
        <div id="faculty-form" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <x-text-input id="register_as" class="hidden" type="text" name="register_as" value="admin" required/>
                <!-- admin name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                        autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                        autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                        required autocomplete="new-password" />
                
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ __('add admin') }}
                    </x-primary-button>
                </div>
            </form>
            </div>
        </div>
        <div id="faculty-list" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="w-full p-2 table-fixed">
                <thead class="w-full">
                    <tr class="bg-slate-500">
                        <th class="text-start px-3 py-2 flex-1">Id</th>
                        <th class="text-start flex-1">Name</th>
                        <th class="text-start flex-1">Email</th>
                        <th>Actions</th>    
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($admins); $i++)
                        <tr class="{{$i % 2 === 0 ? 'bg-gray-200' : 'bg-gray-400'}}">
                            <td class="px-3 py-3">{{$admins[$i]->id}}</td>
                            <td>{{$admins[$i]->user->name}}</td>
                            <td>{{$admins[$i]->user->email}}</td>
                            <td class="text-center">
                                <x-danger-button id="delete-btn" data-admin-id="{{$admins[$i]->id}}">delete
                                </x-danger-button>
                            </td>
                        </tr>
                        <form id="delete-form" method="POST" action="{{'/admin/'.$admins[$i]->id}}">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endfor
                </tbody>
            </table>
            <div class="mt-3">{{$admins->links()}}</div>
        </div>
    </div>

</x-admin-layout>