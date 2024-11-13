<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between align-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-4 grid sm:grid-cols-3 gap-3">
        <x-dashboard-card>{{$institute_count}}</x-dashboard-card>
        <x-dashboard-card title="Faculties">{{$faculty_count}}</x-dashboard-card>
        <x-dashboard-card title="Courses">{{$course_count}}</x-dashboard-card>
        <x-dashboard-card title="Students">{{$student_count}}</x-dashboard-card>
        <x-dashboard-card title="Applications">{{$applications_count}}</x-dashboard-card>
        <x-dashboard-card title="Admissions">{{$admissions_count}}</x-dashboard-card>
    </div>
</x-admin-layout>