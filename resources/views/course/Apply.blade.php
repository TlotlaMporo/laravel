@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Apply for Course</h2>

        <!-- Check if course exists -->
        @if($course)
            <form action="{{ route('apply.course', $course->id) }}" method="POST">
                @csrf
                <!-- Course details (readonly) -->
                <div class="form-group">
                    <label for="course_name">Course Name:</label>
                    <input type="text" class="form-control" id="course_name" value="{{ $course->name }}" readonly>
                </div>

                <!-- Student ID (you can change this based on your model) -->
                <div class="form-group">
                    <label for="student_id">Your Student ID:</label>
                    <input type="text" class="form-control" id="student_id" name="student_id" required>
                </div>

                <!-- Additional fields (if needed) -->
                <div class="form-group">
                    <label for="motivation">Why do you want to apply for this course?</label>
                    <textarea class="form-control" id="motivation" name="motivation" rows="3" required></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit Application</button>
            </form>
        @else
            <p>Course not found.</p>
        @endif
    </div>
@endsection
