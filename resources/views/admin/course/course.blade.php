<x-admin-layout>
    <div class="py-12" x-data="{name:''}">
        <div class="flex justify-between items-center mb-3 sm:px-8">
            <h2 id="title" data-title="Course" data-list="Courses" class="font-bold">New Course</h2>
            <x-primary-button id="faculty">show Courses
            </x-primary-button>
        </div>
        <div id="faculty-form" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6"> 
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form method="POST" action="{{ route('create-course') }}">
                    @csrf
                    <div>
                        <x-input-label for="institute" :value="__('Institute')" />
                        <select id="institute" data-faculties="{{$faculties}}" class=" mt-1 w-full border-gray-300 rounded-md" name="institute"
                                required>
                            <option value="">Select institute</option>
                            @foreach ($institutes as $institute)
                                <option value="{{$institute->id}}">{{$institute->institute_name}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('institute')" class="mt-2" />
                    </div>
                    <!-- faculty field -->
                    <div class="sm:flex gap-3 max-[640px]:block">
                        <div class="flex-1">
                            <!-- Course name field -->
                            <div>
                                <x-input-label for="course_name" :value="__('Course name')" />
                                <x-text-input id="course_name" class="block mt-1 w-full" type="text" name="course_name"
                                    :value="old('course_name')" required autofocus />
                                <x-input-error :messages="$errors->get('course_name')" class="mt-2" />
                            </div>
                            <!-- course code -->
                            <div>
                                <x-input-label for="course_code" :value="__('Course code')" />
                                <x-text-input id="course_code" class="block mt-1 w-full" type="text" name="course_code"
                                    :value="old('course_code')" required />
                                <x-input-error :messages="$errors->get('course_code')" class="mt-2" />
                            </div>
                            <!-- Faculty -->
                            <div>
                                <x-input-label for="faculty" :value="__('Faculty')" />
                                <select id="faculty-select" class=" mt-1 w-full border-gray-300 rounded-md" type="text" name="faculty" required>
                                    <option value="">Select faculty</option> 
                                </select>
                                <x-input-error :messages="$errors->get('level')" class="mt-2" />
                            </div>
                            <!-- Level -->
                            <div>
                                <x-input-label for="level" :value="__('Level')" />
                                <x-text-input id="level" class="block mt-1 w-full" type="text" name="level" :value="old('level')" required
                                    placeholder="Diploma or BSc" />
                                <x-input-error :messages="$errors->get('level')" class="mt-2" />
                            </div>
                            <!-- course_duration-->
                            <div>
                                <x-input-label for="course_duration" :value="__('Course duration')" />
                                <x-text-input id="course_duration" class="block mt-1 w-full" type="text" name="course_duration"
                                    :value="old('course_duration')" placeholder="4 years" required />
                                <x-input-error :messages="$errors->get('course_duration')" class="mt-2" />
                            </div>
                            <!-- course_price per semester -->
                            <div>
                                <x-input-label for="price" :value="__('Tuition fee(per semester)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')"
                                    placeholder="M20,000.00" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <!-- amount of pre-requisites-->
                            <div>
                                <x-input-label for="pass" :value="__('Amount of Passes')" />
                                <x-text-input id="pass" class="block mt-1 w-full" type="number" name="pass" :value="old('pass')" />
                                <x-input-error :messages="$errors->get('pass')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex-1">
                            <!-- subject to be passed to take the course -->
                            <div>
                                <x-input-label for="passed_subject" :value="__('Subjects to be passed')" />
                                <x-text-input id="passed_subject" class="block mt-1 w-full" type="text" name="passed_subject"
                                    :value="old('passed_subject')" placeholder="subjects with comma separated" />
                                <x-input-error :messages="$errors->get('passed_subject')" class="mt-2" />
                            </div>
                            <!-- amount of credits to apply for it-->
                            <div>
                                <x-input-label for="credit_amount" :value="__('Amount of Credits')" />
                                <x-text-input id="credit_amount" class="block mt-1 w-full" type="number" name="credit_amount"
                                    :value="old('credit_amount')" />
                                <x-input-error :messages="$errors->get('credit_amount')" class="mt-2" />
                            </div>
                            <!-- subject to be credited to take the course -->
                            <div>
                                <x-input-label for="credits" :value="__('Credited Subjects')" />
                                <x-text-input id="credits" class="block mt-1 w-full" type="text" name="credits" :value="old('credits')"
                                    placeholder="subjects with comma separated" />
                                <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                            </div>
                    
                            <!-- description -->
                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" class="mt-1 w-full border-gray-300 rounded-md" type="text" name="description"
                                    required autofocus>{{old('description')}}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            <!-- Application requirements -->
                            <div>
                                <x-input-label for="requirements" :value="__('Application requirements')" />
                                <textarea id="requirements" class="mt-1 w-full border-gray-300 rounded-md" type="text" name="requirements"
                                    required autofocus>{{old('requirements')}}</textarea>
                                <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-primary-button class="mt-3">
                            {{__('create course')}}
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
                        <th class="text-start px-3 py-2">Course name</th>
                        <th class="text-start">Institute</th>
                        <th class="text-start">Duration</th>
                        <th class="text-start">Tuition</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($courses); $i++)
                        <tr class="{{$i % 2 === 0 ? 'bg-gray-200' : 'bg-gray-400'}}">
                            <td class="px-3 py-3 hover:underline">
                                <a href="/ad/course/{{$courses[$i]->id}}">
                                    {{$courses[$i]->course_name}}
                                </a>
                            </td>
                            <td>{{$courses[$i]->faculty->institute->institute_name}}</td>
                            <td>{{$courses[$i]->course_duration}}</td>
                            <td>{{$courses[$i]->price}}</td>
                            <td class="text-center">
                                <a href="/ad/course/{{$courses[$i]->id}}/edit">
                                    <x-primary-button>edit
                                    </x-primary-button>
                                </a>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <div class="mt-3">{{$courses->links()}}</div>
        </div>
    </div>
    
</x-admin-layout>