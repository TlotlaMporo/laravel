<x-app-layout> 
    <x-slot name="header">
        <div class="flex justify-between align-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Application') }}
            </h2>
        </div>
    </x-slot>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <h2 class="font-semibold pb-3 text-xl">Apply for {{$course->course_name}}</h2>
            <div class="bg-white overflow-hidden shadow-sm max-[640px]:rounded-lg sm:rounded-lg p-8">
                <form method="POST" action="{{ route('application.store', $course->id) }}">
                    @csrf
                    <div class="sm:flex gap-3 max-[640px]:block">
                        <div class="flex-1">
                            <!-- Passed Subjects: Maximum of 4 fields -->
                            <x-input-label for="passes" :value='__("Subjects you passed (maximum 4)")'/>
                            @for ($i = 0; $i < 4; $i++)
                                <div>
                                    <div class="flex gap-2">
                                        <div class="w-full">
                                            <x-text-input :id="'passed-subject-' . $i" class="block mt-1 w-full" type="text" 
                                                name="passed_subject[]" value="{{ old('passed_subject.' . $i) }}" 
                                                placeholder="Subject you passed" />
                                            <x-input-error :messages="$errors->get('passed_subject.' . $i)" class="mt-2" />
                                        </div>
                                        <div class="w-full">
                                            <x-text-input :id="'passed-grade-' . $i" class="block mt-1 w-full" type="text" 
                                                name="passed_grade[]" value="{{ old('passed_grade.' . $i) }}" 
                                                placeholder="Grade (A)" />
                                            <x-input-error :messages="$errors->get('passed_grade.' . $i)" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            <!-- Credit Subjects: Minimum of 3 fields -->
                            <x-input-label class="mt-3" for="credits" :value='__("Subjects you have credits (minimum 3)")' />
                            @for ($i = 0; $i < 3; $i++)
                                <div>
                                    <div class="flex gap-2">
                                        <div class="w-full">
                                            <x-text-input :id="'credit-subject-' . $i" class="block mt-1 w-full" type="text" 
                                                name="credit_subject[]" value="{{ old('credit_subject.' . $i) }}" 
                                                placeholder="Subject with credit" />
                                            <x-input-error :messages="$errors->get('credit_subject.' . $i)" class="mt-2" />
                                        </div>
                                        <div class="w-full">
                                            <x-text-input :id="'credit-grade-' . $i" class="block mt-1 w-full" type="text" 
                                                name="credit_grade[]" value="{{ old('credit_grade.' . $i) }}" 
                                                placeholder="Grade (A)" />
                                            <x-input-error :messages="$errors->get('credit_grade.' . $i)" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            <x-input-error :messages="$errors->get('general')" class="mt-2" />
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
