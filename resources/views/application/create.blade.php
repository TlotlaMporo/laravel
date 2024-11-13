<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between align-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Application') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <h2 class="font-semibold pb-3 text-xl">Apply for {{$course->course_name}}</h2>
            <div class="bg-white overflow-hidden shadow-sm max-[640px]:rounded-lg sm:rounded-lg p-8">
                <form method="POST" action="{{ route('application.store', $course->id) }}">
                    @csrf
                    <div class="sm:flex gap-3 max-[640px]:block">
                        <div class="flex-1">
                            
                            <x-input-label for="passes" :value='__("Subject you passed($course->passed_subject must be included)")'/>
                            @for ($i = 0; $i < $course->pass; $i++)
                                   <div>
                                        <div class="flex gap-2">
                                            <div class="w-full">
                                              <x-text-input :id="'label-' . $i" class="block mt-1 w-full" type="text" :name="'passed_subject_' . $i + 1"
                                            :value='(count($passed) > $i) ? $passed[$i] : old("passed_subject_" . $i + 1)'
                                            autofocus
                                            required
                                            :readonly="(count($passed) > $i)"
                                            :placeholder='"Subject " . $i + 1'/>
                                            <x-input-error :messages='$errors->get("passed_subject_" . $i + 1)' class="mt-2" />
                                            </div>
                                        <div class="w-full">
                                            <x-text-input :id="'value-' . $i" class="block mt-1 w-full" type="text" :name="'passed_grade_' . $i + 1"
                                            :value="old('value-{$i}')" autofocus 
                                            placeholder="Grade(A)"
                                            required
                                            />
                                            <x-input-error :messages='$errors->get("passed_grade_" . $i + 1)' class="mt-2" />
                                        </div>
                                        </div>
                                    </div> 
                            @endfor
                            <x-input-label class="mt-3" for="credits" :value='__("Subject you have credits")' />
                            @for ($i = 0; $i < $course->credit_amount; $i++)
                                   <div>
                                        <div class="flex gap-2">
                                            <div class="w-full">
                                               <x-text-input :id="'label-' . $i" class="block mt-1 w-full" type="text" :name="'credit_subject_' . $i + 1"
                                            :value="(count($credits) > $i) ? $credits[$i] : old('value-{$i}')"
                                            :required
                                            :readonly="(count($credits) > $i)"
                                            :placeholder="'Subject ' . $i + 1"/>  
                                            <x-input-error :messages="$errors->get('credit_subject_' . $i + 1)" class="mt-2" />
                                            </div>
                                        <div class="w-full">
                                           <x-text-input :id="'value-' . $i" class="block mt-1 w-full" type="text" :name="'credit_grade_' . $i + 1"
                                            :value="old('value-{$i}')" autofocus 
                                            placeholder="Grade(A)"
                                            required
                                            /> 
                                            <x-input-error :messages="$errors->get('credit_grade_' . $i + 1)" class="mt-2" />
                                        </div>

                                        </div>

                                        <x-input-error :messages="$errors->get('course_name')" class="mt-2" />
                                    </div> 
                            @endfor
                            <x-input-error :messages='$errors->get("general")' class="mt-2" />
                        </div>  
                        </div>
                    </div>
                    <div>
                        <x-primary-button class="mt-3 bg-green-500">
                            {{ __('Apply') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


