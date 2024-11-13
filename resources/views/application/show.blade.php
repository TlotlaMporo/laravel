<x-app-layout x-data="{open:false}">
    <x-slot name="header">
        <div class="flex justify-between align-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Application for " . ($application->student->full_name ?? 'Unknown Student')) }}
            </h2>
            <div>
                @if ($status !== 'admitted')
                    @can('institute')
                        <form method="POST" action='{{ url("/applications/$application->id") }}'>
                            @csrf
                            @method("PATCH")
                            <x-primary-button class="bg-green-500" name="action" value="admit">Admit</x-primary-button>
                            <x-primary-button name="action" value="waitlist">Waitlist</x-primary-button>
                            <x-danger-button name="action" value="reject">Reject</x-danger-button>
                        </form>
                    @endcan
                @else
                    @can('institute')
                        <x-primary-button class="bg-green-500" disabled>Admitted</x-primary-button>
                    @endcan
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-6">
        <section class="flex flex-col p-6 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg shadow-xl">
            <div class="md:flex md:items-start md:justify-between md:gap-2">
                <div class="min-w-0">
                    <div class="inline-block rounded-full bg-gray-500 px-3 py-2 text-lg font-bold text-white">
                        Application Id: {{ $application->id ?? 'N/A' }}
                    </div>
                </div>

                <div class="hidden text-right md:block">
                    <div>
                        <span class="inline-block rounded-full bg-gray-200 px-3 py-2 text-sm text-gray-900 dark:bg-gray-800 dark:text-white">
                            <span class="font-bold pr-1">Course:</span>
                            {{ $application->course->course_name ?? 'Unknown Course' }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto mb-6 mt-3">
            <h2 class="font-semibold pb-1 text-xl">Results</h2>
            <div id="credits" class="bg-white overflow-hidden shadow-sm p-8 flex gap-3 justify-between">
                
                <!-- Passes Table -->
                <table class="w-[250px]">
                    <caption class="font-bold">Passes</caption>
                    <tr>
                        <th class="text-sm font-bold text-left">Subject</th>
                        <th class="text-sm font-bold text-center">Grade</th>
                    </tr>
                    @php
                        // Ensure $results object exists
                        $results = $results ?? (object)[];
                        for ($i = 0; $i < ($application->course->pass ?? 0); $i++) {
                            $subjectKey = "passed_subject_" . ($i + 1);
                            $gradeKey = "passed_grade_" . ($i + 1);
                            echo "<tr>
                                <td class='w-[100px] text-left'>" . ($results->$subjectKey ?? 'N/A') . "</td>
                                <td class='w-[100px] text-center'>" . ($results->$gradeKey ?? 'N/A') . "</td>
                              </tr>";
                        }
                    @endphp
                </table>

                <!-- Credits Table -->
                <table class="w-[250px]">
                    <caption class="font-bold">Credits</caption>
                    <tr>
                        <th class="text-sm font-bold text-left">Subject</th>
                        <th class="text-sm font-bold text-center">Grade</th>
                    </tr>
                    @php
                        for ($i = 0; $i < ($application->course->credit_amount ?? 0); $i++) {
                            $subjectKey = "passed_subject_" . ($i + 1);
                            $gradeKey = "passed_grade_" . ($i + 1);
                            echo "<tr>
                                <td class='w-[100px] text-left'>" . ($results->$subjectKey ?? 'N/A') . "</td>
                                <td class='w-[100px] text-center'>" . ($results->$gradeKey ?? 'N/A') . "</td>
                              </tr>";
                        }
                    @endphp
                </table>
            </div>
        </div>

        <!-- Status Modal Messages -->
        @if (session('status') === 'application-updated')
            <x-confirm-modal :name="'update'" :content="'The student has already been admitted'"></x-confirm-modal>
        @endif
        @if (session('status') === 'application-admitted')
            <x-confirm-modal :name="'create'" :content="'The student has been admitted successfully'"></x-confirm-modal>
        @endif
        @if (session('status') === 'application-waitlisted')
            <x-confirm-modal :name="'create'" :content="'The student has been waitlisted successfully'"></x-confirm-modal>
        @endif
        @if (session('status') === 'application-rejected')
            <x-confirm-modal :name="'create'" :content="'The student has been rejected successfully'"></x-confirm-modal>
        @endif
    </div>
</x-app-layout>
