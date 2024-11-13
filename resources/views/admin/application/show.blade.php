<x-admin-layout x-data="{open:false}">
    
    <div class="py-12 px-6">
        <div name="header">
        <div class="flex justify-between align-center mb-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Application for " . $application->student->full_name) }}
            </h2>
            <div>
                @if ($status !== 'admitted')
                    @can('admin')
                        <form method="POST" action='{{"/applications/$application->id"}}'>
                            @csrf
                            @method("PATCH")
                            <x-primary-button class="bg-green-500" name="action" value="admit">
                                Admit
                            </x-primary-button>
                            @if($application->status !== 'waitlisted')
                            <x-primary-button name="action" value="waitlist">Waitlist
                            </x-primary-button>
                            @endif
                            @if($application->status !== 'rejected')
                                <x-danger-button name="action" value="reject">{{ __('Reject') }}
                                </x-danger-button>
                            @endif
            
                            
                        </form>
                    @endcan
                @else
                    @can('admin')
                            <x-primary-button class="bg-green-500"  
                                disabled>
                                Admitted
                            </x-primary-button> 
                    @endcan
                @endif
                
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
                            Application Id: {{$application->id}}
                        </span>
                        <span class="md:hidden">
                            Application Id:{{$application->id}}
                        </span>
                    </div>
                </div>

                <div class="hidden text-right shrink-0 md:block md:min-w-64 md:max-w-80">
                    <div>
                        <span
                            class="inline-block rounded-full bg-gray-200 px-3 py-2 text-sm leading-5 text-gray-900 max-w-full truncate dark:bg-gray-800 dark:text-white">
                            <span class="font-bold pr-1">Course:</span>
                            {{$application->course->course_name}}
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <div class="max-w-7xl mx-auto mb-6 mt-3">
            <h2 class="font-semibold pb-1 text-xl">Results</h2>
            <div id="credits"
                class="bg-white overflow-hidden shadow-sm max-[640px]:rounded-lg sm:rounded-lg p-8 flex gap-3 justify-between" >
                <table class="w-[250px]">
                    <caption class="font-bold">Passes</caption>
                    <tr>
                    <th class="text-sm font-bold text-left">
                        Subject
                    </th>
                    <th class="text-sm font-bold text-center">
                        Grade
                    </th>
                </tr>
                @php
for ($i = 0; $i < $application->course->pass; $i++) {
    $f = "passed_subject_" . $i + 1;
    $v = "passed_grade_" . $i + 1;
    $d = $i % 2 === 0;
    echo "<tr>
                            <td class='w-[100px] text-left'>{$results->$f}</td>
                            <td class='w-[100px] text-center'>{$results->$v}</td>
                        </tr>
                        ";
}
                @endphp
                </table>
                <table class="w-[250px]">
                    <caption class="font-bold">Credits</caption>
                    <tr>
                        <th class="text-sm font-bold text-left">
                            Subject
                        </th>
                        <th class="text-sm font-bold text-center">
                            Grade
                        </th>
                    </tr>
                    @php
for ($i = 0; $i < $application->course->credit_amount; $i++) {
    $f = "passed_subject_" . $i + 1;
    $v = "passed_grade_" . $i + 1;
    $d = $i % 2 === 0;
    echo "<tr>
                                    <td class='w-[100px] text-left'>{$results->$f}</td>
                                    <td class='w-[100px] text-center'>{$results->$v}</td>
                                </tr>
                                ";
}
                    @endphp
                </table>
            </div>
        </div>
        @if (session('status') === 'application-updated')
            <x-confirm-modal :name="'update'" :content="'The student already admitted'">
            </x-confirm-modal>
        @endif
        @if (session('status') === 'application-admitted')
            <x-confirm-modal :name="'create'" :content="'The student admitted successfully'">
            </x-confirm-modal>
        @endif
        @if (session('status') === 'application-waitlisted')
            <x-confirm-modal :name="'create'" :content="'The student waitlisted successfully'">
            </x-confirm-modal>
        @endif
        @if (session('status') === 'application-rejected')
            <x-confirm-modal :name="'create'" :content="'The student rejected successfully'">
            </x-confirm-modal>
        @endif
    </div>
</x-app-layout>