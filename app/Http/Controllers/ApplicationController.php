<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    // Show the form to apply for a course
    public function create($id)
    {
        $course = Course::findOrFail($id);
        return view('application.create', compact('course'));
    }

    // Store the application
    public function store(Request $request, $id)
    {
        // Validate the input with custom validation rules
        $validated = $request->validate([
            'passed_subject.0' => 'required|string|max:255',
            'passed_subject.1' => 'required|string|max:255',
            'passed_subject.2' => 'nullable|string|max:255',
            'passed_subject.3' => 'nullable|string|max:255',
            'passed_grade.0' => 'required|string|max:2',
            'passed_grade.1' => 'required|string|max:2',
            'passed_grade.2' => 'nullable|string|max:2',
            'passed_grade.3' => 'nullable|string|max:2',
            'credit_subject.0' => 'required|string|max:255',
            'credit_subject.1' => 'required|string|max:255',
            'credit_subject.2' => 'required|string|max:255',
            'credit_subject.3' => 'nullable|string|max:255',
            'credit_grade.0' => 'required|string|max:2',
            'credit_grade.1' => 'required|string|max:2',
            'credit_grade.2' => 'required|string|max:2',
            'credit_grade.3' => 'nullable|string|max:2',
        ], [
            'passed_subject.0.required' => 'You must provide at least one passed subject.',
            'passed_subject.1.required' => 'You must provide at least two passed subjects.',
            'credit_subject.0.required' => 'You must provide at least three credit subjects.',
            'credit_subject.1.required' => 'You must provide at least three credit subjects.',
            'credit_subject.2.required' => 'You must provide at least three credit subjects.',
        ]);

        // Find the course to which the application is being made
        $course = Course::findOrFail($id);

        // Create the application and assign student_id from the authenticated user
        $application = new Application([
            'student_id' => Auth::id(),
            'course_id' => $course->id,
            'passed_subjects' => json_encode($validated['passed_subject']),
            'passed_grades' => json_encode($validated['passed_grade']),
            'credit_subjects' => json_encode($validated['credit_subject']),
            'credit_grades' => json_encode($validated['credit_grade']),
        ]);

        // Save the application
        $application->save();

        // Redirect with success message
        return redirect()->route('application.index')->with('success', 'Application submitted successfully!');
    }

    // Show the list of applications
    public function index()
    {
        if (Auth::user()->can('institute')) {
            // Group applications by status for the institute
            $applications = [
                0 => Application::where('status', 'Pending')
                    ->whereHas('course.faculty.institute', function ($query) {
                        $query->where('id', Auth::user()->institute->id);
                    })
                    ->get(),
                1 => Application::where('status', 'Admitted')
                    ->whereHas('course.faculty.institute', function ($query) {
                        $query->where('id', Auth::user()->institute->id);
                    })
                    ->get(),
                2 => Application::where('status', 'Waitlisted')
                    ->whereHas('course.faculty.institute', function ($query) {
                        $query->where('id', Auth::user()->institute->id);
                    })
                    ->get(),
                3 => Application::where('status', 'Rejected')
                    ->whereHas('course.faculty.institute', function ($query) {
                        $query->where('id', Auth::user()->institute->id);
                    })
                    ->get(),
            ];
        } elseif (Auth::user()->can('student')) {
            // Only fetch the student's own applications
            $applications = Application::where('student_id', Auth::id())->get();
        } else {
            abort(403); // Unauthorized access
        }

        return view('application.index', compact('applications'));
    }

    // Show a specific application
    public function show($id)
    {
        $application = Application::findOrFail($id);
        return view('application.show', compact('application'));
    }
}
