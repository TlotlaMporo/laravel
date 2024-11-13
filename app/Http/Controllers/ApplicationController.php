<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Course;
use Arr;
use Auth;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Redirect;

class ApplicationController extends Controller
{
    public function create($id)
    {
        if (Gate::denies('student')) {
            return redirect('/dashboard');
        }
        $course = Course::findOrFail($id);
        if ($course->faculty->institute->control->applications !== 'open') {
            return redirect('/dashboard');
        }

        $passed = explode(',', $course->passed_subject);
        $credits = explode(',', $course->credits);
        return view('application.create', ['course' => $course, 'passed' => $passed, 'credits' => $credits]);
    }

    public function show(Request $request, $id): View 
    {
        $application = Application::findOrFail($id);
        $results = json_decode($application->grades);
        $student_applications = $application->student->application;
        $status = '';

        foreach ($student_applications as $app) {
            if ($app->status === 'admitted') {
                $status = $app->status;
            } 
        }
        if (Auth::user()?->admin) {
            return view('admin.application.show', ['application' => $application, 'results' => $results, 'status' => $status]);
        }
        return view('application.show', ['application' => $application, 'results' => $results, 'status' => $status]);
    }

    public function index(): View
    {
        $applications = [];
        
        if (Gate::allows('student')) {
            $applications = Auth::user()?->student?->application;
        }
    
        if (Gate::allows('institute')) {
            $institute = Auth::user()->institute;
            $courses = [];
            $institute_applications = [];
    
            // Check if faculty exists and is iterable (either array or collection)
            if ($institute->faculty && ($institute->faculty instanceof \Illuminate\Database\Eloquent\Collection || is_array($institute->faculty))) {
                foreach ($institute->faculty as $faculty) {
                    // Ensure $faculty->course is an iterable object
                    if ($faculty->course && ($faculty->course instanceof \Illuminate\Database\Eloquent\Collection || is_array($faculty->course))) {
                        if ($faculty->course->isNotEmpty()) {
                            array_push($courses, $faculty->course);
                        }
                    }
                }
            }
    
            // Check if courses were found and iterate through them
            if (!empty($courses)) {
                foreach ($courses as $course_in_faculty) {
                    foreach ($course_in_faculty as $course) {
                        // Ensure $course->application is iterable
                        if ($course->application && ($course->application instanceof \Illuminate\Database\Eloquent\Collection || is_array($course->application))) {
                            foreach ($course->application as $app) {
                                array_push($institute_applications, $app);
                            }
                        }
                    }
                }
            }
    
            // Categorize applications by their status
            $applications_pending = Arr::where($institute_applications, function ($app) {
                return $app->status === 'pending';
            });
            $applications_admitted = Arr::where($institute_applications, function ($app) {
                return $app->status === 'admitted';
            });
            $applications_waitlisted = Arr::where($institute_applications, function ($app) {
                return $app->status === 'waitlisted';
            });
            $applications_rejected = Arr::where($institute_applications, function ($app) {
                return $app->status === 'rejected';
            });
    
            $applications = [$applications_pending, $applications_admitted, $applications_waitlisted, $applications_rejected];
        }
    
        if (Gate::allows('admin')) {
            $all_applications = Application::all();
            
            $applications_pending = $all_applications->where('status', 'pending');
            $applications_admitted = $all_applications->where('status', 'admitted');
            $applications_waitlisted = $all_applications->where('status', 'waitlisted');
            $applications_rejected = $all_applications->where('status', 'rejected');
            $applications = [$applications_pending, $applications_admitted, $applications_waitlisted, $applications_rejected];
        }
    
        return view(Auth::user()?->admin ? 'admin.application.index' : 'application.index', ['applications' => $applications]);
    }
    
    public function store(Request $request, $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $passed_chars = ['A', 'B', 'C', 'D', 'a', 'b', 'c', 'd'];
        $credit_chars = ['A', 'B', 'C', 'a', 'b', 'c'];
        $validated = [];
        $data = [];
        $data_credits = [];

        // Validation for passed_subject and passed_grade
        for ($i = 0; $i < $course->pass; $i++) {
            $validated += $request->validate([
                "passed_subject_" . ($i + 1) => ['required', 'string'],
                "passed_grade_" . ($i + 1) => ['required', 'string', 'max:1']
            ]);
            $data[] = "passed_subject_" . ($i + 1);
        }

        // Validation for credit_subject and credit_grade
        for ($i = 0; $i < $course->credit_amount; $i++) {
            $validated += $request->validate([
                "credit_subject_" . ($i + 1) => ['required', 'string'],
                "credit_grade_" . ($i + 1) => ['required', 'string', 'max:1']
            ]);
            $data_credits[] = "credit_subject_" . ($i + 1);
        }

        // Validation for passed_grades
        for ($i = 0; $i < $course->pass; $i++) {
            $field = "passed_grade_" . ($i + 1);
            $char = $request->$field;
            if (!in_array($char, $passed_chars, true)) {
                throw ValidationException::withMessages([
                    $field => "Sorry, you do not meet the requirements."
                ]);
            }
        }

        // Validation for credit_grades
        for ($i = 0; $i < $course->credit_amount; $i++) {
            $field = "credit_grade_" . ($i + 1);
            $char = $request->$field;
            if (!in_array($char, $credit_chars, true)) {
                throw ValidationException::withMessages([
                    $field => 'Sorry, you do not meet the requirements.'
                ]);
            }
        }

        // Check for duplicate subjects in passed and credit arrays
        for ($i = 0; $i < $course->pass; $i++) {
            $field = "passed_subject_" . ($i + 1);
            $f = Arr::where($data, function ($sub) use ($field) {
                return $field !== $sub;
            });
            $m = Arr::map($f, function ($sub) use ($request, $field) {
                return strtolower($request->$sub);
            });
            $char = strtolower($request->$field);
            if (in_array($char, $m, true)) {
                throw ValidationException::withMessages([
                    $field => "The subject is already added ($char)."
                ]);
            }
        }

        // Check if student already has a pending application for this course
        $pending_student_applications = Application::where('student_id', Auth::user()->id)
            ->where('course_id', $id)
            ->where('status', 'pending')
            ->exists();

        if ($pending_student_applications) {
            throw ValidationException::withMessages([
                "general" => "You have already applied for this course.",
            ]);
        }

        // Check if student has already applied for more than 2 courses in the institute
        $institute_student_applications = Application::where('student_id', Auth::user()->id)
            ->whereHas('course.faculty.institute', function ($query) {
                $query->where('id', Auth::user()->student->institute_id);
            })
            ->where('status', 'pending')
            ->count();

        if ($institute_student_applications >= 2) {
            throw ValidationException::withMessages([
                "general" => "You can only apply for 2 courses per institute.",
            ]);
        }

        // Create the application
        Application::create([
            'status' => 'pending',
            'course_id' => $id,
            'student_id' => Auth::user()?->student?->id,
            'grades' => json_encode($validated),
        ]);

        return Redirect::route('courses')->with('status', 'application-created');
    }
}
