<x-app-layout x-data="{ open: false }">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __($course->course_name) }}
            </h2>
            <div>
                @auth
                    @can('action-on-course', $course->id)
                        <a href="{{ route('course.edit', $course->id) }}">
                            <x-primary-button>Edit course</x-primary-button>
                        </a>
                        <x-danger-button x-on:click.prevent="$dispatch('open-modal', 'confirm-course-deletion')">
                            {{ __('Delete course') }}
                        </x-danger-button>
                    @endcan

                    @can('student')
                        @if(optional(optional($course->faculty->institute)->control)->applications === 'open')
                            <a href="{{ route('course.apply', $course->id) }}">
                                <x-primary-button class="bg-green-500">Apply</x-primary-button>
                            </a>
                        @else
                            <x-primary-button disabled>Applications closed</x-primary-button>
                        @endif
                    @endcan
                @endauth
            </div>
        </div>
    </x-slot>

    <x-modal name="confirm-course-deletion" :show="$errors->courseDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('course.destroy', $course->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this course [' . $course->course_name . ']?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('The course will be permanently deleted.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                <x-danger-button class="ms-3">{{ __('Delete Course') }}</x-danger-button>
            </div>
        </form>
    </x-modal>

    <div class="py-12 px-6">
        <section class="flex flex-col p-6 sm:p-6 bg-white dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 rounded-lg shadow-xl">
            <div class="md:flex md:items-start md:justify-between md:gap-2">
                <div class="min-w-0">
                    <div class="inline-block rounded-full bg-gray-500 px-3 py-2 text-lg font-bold text-white truncate lg:text-base dark:bg-gray-500/20">
                        <span class="hidden md:inline">About the course</span>
                        <span class="md:hidden">About the course</span>
                    </div>
                    <div class="mt-4 text-lg font-semibold text-gray-900 break-words dark:text-white lg:text-2xl">
                        <span class="font-bold pr-1">Course description:</span> {{$course->description}}
                    </div>
                    <div class="mt-4 text-lg font-semibold text-gray-900 break-words dark:text-white lg:text-2xl">
                        <span class="font-bold pr-1">Course Level:</span> {{$course->level}}
                    </div>
                    <div class="mt-4 text-lg font-semibold text-gray-900 break-words dark:text-white lg:text-2xl">
                        <span class="font-bold pr-1">Duration:</span> {{$course->course_duration}}
                    </div>
                    <div class="mt-4 text-lg font-semibold text-gray-900 break-words dark:text-white lg:text-2xl">
                        <span class="font-bold pr-1">Tuition fee (per annum):</span> {{$course->price}}
                    </div>
                    <div class="mt-4 text-lg font-semibold text-gray-900 break-words dark:text-white lg:text-2xl">
                        <span class="font-bold pr-1">Institute:</span> {{$course->faculty->institute->institute_name ?? 'N/A'}}
                    </div>
                    <div class="mt-4 text-lg font-semibold text-gray-900 break-words dark:text-white lg:text-2xl">
                        <span class="font-bold pr-1">Institute Location:</span> {{$course->faculty->institute->location ?? 'N/A'}}
                    </div>
                </div>

                <div class="hidden text-right shrink-0 md:block md:min-w-64 md:max-w-80">
                    <div>
                        <span class="inline-block rounded-full bg-gray-200 px-3 py-2 text-sm leading-5 text-gray-900 max-w-full truncate dark:bg-gray-800 dark:text-white">
                            <span class="font-bold pr-1">Faculty:</span> {{$course->faculty->faculty_name ?? 'N/A'}}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto mb-6 mt-3">
            <h2 class="font-semibold pb-1 text-xl">Course Requirements</h2>
            <div id="credits" data-passed="{{$course->passed_subject}}" data-credits="{{$course->credits}}"
                class="bg-white overflow-hidden shadow-sm max-[640px]:rounded-lg sm:rounded-lg p-8">
                <p class="text-lg">
                    To apply for this course, you have to pass {{$course->passed_subject}} subjects, including {{$course->passed_subject}}. The applicant is also required to have credits in these subjects: <span class="text-red-500/50">{{$course->credits}}</span>.
                </p>
                <p class="text-lg">{{$course->requirements}}</p>
            </div>
        </div>

        @if (session('status') === 'course-updated')
            <x-confirm-modal :name="'update'" :content="'The course updated successfully'"></x-confirm-modal>
        @endif

        @if (session('status') === 'course-created')
            <x-confirm-modal :name="'create'" :content="'The course created successfully'"></x-confirm-modal>
        @endif
    </div>
</x-app-layout>
