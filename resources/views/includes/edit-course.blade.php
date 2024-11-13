<form method="POST" action="{{ route('course.update', $course->id) }}">
    @csrf
    @method('PATCH')
    <div class="sm:flex gap-3 max-[640px]:block">
        <div class="flex-1">
            <!-- Course name field -->
            <div>
                <x-input-label for="course_name" :value="__('Course name')" />
                <x-text-input id="course_name" class="block mt-1 w-full" type="text" name="course_name" :value="$course->course_name"
                    required autofocus />
                <x-input-error :messages="$errors->get('course_name')" class="mt-2" />
            </div>
            <!-- course code -->
            <div>
                <x-input-label for="course_code" :value="__('Course code')" />
                <x-text-input id="course_code" class="block mt-1 w-full" type="text" name="course_code"
                    :value="$course->course_code" required />
                <x-input-error :messages="$errors->get('course_code')" class="mt-2" />
            </div>
            <!-- Faculty -->
            <div>
                <x-input-label for="faculty" :value="__('Faculty')" />
                <select id="faculty" class=" mt-1 w-full border-gray-300 rounded-md" type="text" name="faculty"
                    required>
                    <option value="">Select faculty</option>
                    @if ($faculties)
                        @foreach ($faculties as $faculty)
                            <option {{ $course->faculty->id === $faculty->id ? 'selected' : '' }}
                                value="{{ $faculty->id }}">{{ $faculty->faculty_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <x-input-error :messages="$errors->get('level')" class="mt-2" />
            </div>
            <!-- Level -->
            <div>
                <x-input-label for="level" :value="__('Level')" />
                <x-text-input id="level" class="block mt-1 w-full" type="text" name="level" :value="$course->level"
                    required placeholder="Diploma or BSc" />
                <x-input-error :messages="$errors->get('level')" class="mt-2" />
            </div>
            <!-- course_duration-->
            <div>
                <x-input-label for="course_duration" :value="__('Course duration')" />
                <x-text-input id="course_duration" class="block mt-1 w-full" type="text" name="course_duration"
                    :value="$course->course_duration" placeholder="4 years" required />
                <x-input-error :messages="$errors->get('course_duration')" class="mt-2" />
            </div>
            <!-- course_price per anual -->
            <div>
                <x-input-label for="price" :value="__('Tuition fee(per anual)')" />
                <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="$course->price"
                    placeholder="M20,000.00" required />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
            <!-- amount of pre-requisites-->
            <div>
                <x-input-label for="pass" :value="__('Amount of Passes')" />
                <x-text-input id="price" class="block mt-1 w-full" type="number" name="pass" :value="$course->pass"
                    required />
                <x-input-error :messages="$errors->get('pass')" class="mt-2" />
            </div>
        </div>
        <div class="flex-1">
            <!-- subject to be passed to take the course -->
            <div>
                <x-input-label for="passed_subject" :value="__('Subjects to be passed')" />
                <x-text-input id="passed_subject" class="block mt-1 w-full" type="text" name="passed_subject"
                    :value="$course->passed_subject" placeholder="subjects with comma separated" />
                <x-input-error :messages="$errors->get('passed_subject')" class="mt-2" />
            </div>
            <!-- amount of credits to apply for it-->
            <div>
                <x-input-label for="credit_amount" :value="__('Amount of Credits')" />
                <x-text-input id="credit_amount" class="block mt-1 w-full" type="number" name="credit_amount"
                    :value="$course?->credit_amount" />
                <x-input-error :messages="$errors->get('credit_amount')" class="mt-2" />
            </div>
            <!-- subject to be credited to take the course -->
            <div>
                <x-input-label for="credits" :value="__('Credited Subjects')" />
                <x-text-input id="credits" class="block mt-1 w-full" type="text" name="credits" :value="$course?->credits"
                    placeholder="subjects with comma separated" />
                <x-input-error :messages="$errors->get('credits')" class="mt-2" />
            </div>

            <!-- description -->
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" class="mt-1 w-full border-gray-300 rounded-md" type="text"
                name="description"
                required>{{ $course->description }}
                </textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <!-- Application requirements -->
            <div>
                <x-input-label for="description" :value="__('Application requirements')" />
                <textarea id="requirements" class="mt-1 w-full border-gray-300 rounded-md" type="text" name="requirements" required
                    autofocus>{{ $course->requirements }}</textarea>
                <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
            </div>
        </div>
    </div>


    <div>
        <x-primary-button class="mt-3">
            {{ __('Update Course') }}
        </x-primary-button>
    </div>
</form>
