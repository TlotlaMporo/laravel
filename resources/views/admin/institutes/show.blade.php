<x-admin-layout>
    <div class="py-12 sm:px-6">
        <div name="header">
            <div class="md:flex justify-between align-center mb-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __($institute->institute_name) }}
            </h2>
            <div>
               @can('admin')
                    <form method="POST" action="/control/{{$institute->id}}">
                        @csrf
                        @method("PATCH")
                    @if ((count($applications) > 0))
                        <x-primary-button class="bg-green-500" name="action" value="admission">
                            {{($institute->control->admissions !== 'open') ? 'Publish Admissions' : 'Admissions Published'}}
                        </x-primary-button>
                    @endif
                    <x-primary-button class="bg-green-500" name="action" value="application">
                        {{($institute->control->applications !== 'open') ? 'Open Applications' : 'Close Applications'}}

                    </x-primary-button>
                </form>
                @endcan
            </div>
            </div>
        </div>
        <section
            class="@container flex flex-col p-6 sm:p-6 bg-white dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 rounded-lg default:col-span-full default:lg:col-span-6 default:row-span-1 dark:ring-1 dark:ring-gray-800 shadow-xl">
            <div class="md:flex md:items-start md:justify-between md:gap-2">
                <div class="min-w-0">
                    <div
                        class="inline-block rounded-full bg-gray-500 px-3 py-2 max-w-full text-lg font-bold leading-5 text-white truncate lg:text-base dark:bg-gray-500/20">
                        <span class="hidden md:inline">
                            About the Institution
                        </span>
                        <span class="md:hidden">
                            About the Institution
                        </span>
                    </div>
                    <div class="mt-4 text-lg font-semibold text-gray-900 break-words dark:text-white lg:text-2xl">
                        <span class="font-bold pr-1">Location:</span> {{ $institute->location }}
                    </div>
                    <div class="mt-4 text-lg font-semibold text-gray-900 break-words dark:text-white lg:text-2xl">
                        <span class="font-bold pr-1">Phone:</span> {{ $institute->phone }}
                    </div>
                    
                </div>

                <div class=" text-right shrink-0 md:block">
                    <div>
                        <span
                            class="inline-block rounded-full bg-gray-200 px-3 py-2 text-sm leading-5 text-gray-900 max-w-full md:whitespace-nowrap dark:bg-gray-800 dark:text-white">
                            <span class="font-bold pr-1">Email:</span>
                            {{ $institute->email }}
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <div class="max-w-7xl mx-auto mb-6 mt-3">
            <h2 class="font-semibold pb-1 text-xl">Faculties and Courses</h2>
            <div class="bg-white overflow-hidden shadow-sm max-[640px]:rounded-lg sm:rounded-lg p-4 md:p-8">
                @forelse($institute->faculty as $faculty)
                <h2 class="font-semibold pb-1 text-xl">Faculty of {{$faculty->faculty_name}}</h2>
                    @forelse($faculty->course as $course)
                        <li class="text-lg ml-4">{{$course->course_name}}</li>
                    @empty
                    <p class="text-lg ml-4">No Courses just yet</p>
                    @endforelse
                @empty
                    <p class="text-lg ">No faculties just yet</p>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>