<!-- resources/views/dashboard/institution.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="display-4 text-center mb-4">Welcome to Your Institution Dashboard, {{ Auth::user()->institute->name }}</h1>

    <div class="row">
        <!-- Faculty Overview -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4>Faculties</h4>
                </div>
                <div class="card-body">
                    @if($faculties->isEmpty())
                        <p>No faculties available yet.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($faculties as $faculty)
                                <li class="list-group-item">{{ $faculty->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Courses Overview -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h4>Courses</h4>
                </div>
                <div class="card-body">
                    @if($courses->isEmpty())
                        <p>No courses available yet.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($courses as $course)
                                <li class="list-group-item">
                                    <strong>{{ $course->course_name }}</strong> 
                                    ({{ $course->course_code }})
                                    <br> Faculty: {{ $course->faculty->name }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Student Overview -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h4>Student Count</h4>
                </div>
                <div class="card-body">
                    <p class="h5">Total number of students: <strong>{{ $studentCount }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Section -->
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <h4 class="mb-4">Actions</h4>
            <a href="{{ route('course.create') }}" class="btn btn-primary btn-lg mx-2">Create New Course</a>
            <a href="{{ route('faculty.create') }}" class="btn btn-secondary btn-lg mx-2">Create New Faculty</a>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card-header {
        font-weight: bold;
    }
    .card-body {
        background-color: #f8f9fa;
    }
    .btn-lg {
        padding: 12px 24px;
        font-size: 16px;
    }
    .display-4 {
        font-size: 2.5rem;
    }
    .list-group-item {
        font-size: 1.1rem;
    }
    .shadow-sm {
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
