<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Faculty;
use Auth;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Redirect;

class CourseController extends Controller
{
    public function index(): View
    {
        $faculties = Auth::user()?->institute?->faculty;
        $courses = Course::with('faculty')->paginate(3);
    
        if (Auth::user()?->institute) {
            $courses = [];
            $institute = Auth::user()->institute;
            $institute_courses = [];
    
            // Check if faculty exists and is not empty
            if ($institute->faculty && $institute->faculty->isNotEmpty()) {
                foreach ($institute->faculty as $faculty) {
                    // Ensure course is a valid collection before pushing
                    if ($faculty->course && $faculty->course->isNotEmpty()) {
                        array_push($courses, $faculty->course);
                    }
                }
            }
    
            foreach ($courses as $course_in_faculty) {
                foreach ($course_in_faculty as $course) {
                    array_push($institute_courses, $course);
                }
            }
            
            $courses = $institute_courses;
        }
    
        return view('course.course', ['faculties' => $faculties, 'courses' => $courses]);
    }

    public function create()
    {
        if (Gate::denies('institute')) {
            return redirect('/dashboard');
        }

        // Get the authenticated user's institute
        $institute = Auth::user()->institute;

        // Fetch faculties that belong to the current institute
        $faculties = Faculty::where('institute_id', $institute->id)->get();  

        // Fetch courses (if necessary)
        $courses = Course::with('faculty')->paginate(5);

        return view('course.create', compact('faculties'));  
    }

    public function show($id): View
    {
        $faculties = Auth::user()?->institute?->faculty;
        $course = Course::findOrFail($id);
        
        return view('course.show', ['faculties' => $faculties, 'course' => $course]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('admin-institute')) {
            return redirect('/dashboard');
        }

        $validated = $request->validate([
            'course_name' => ['required', 'string', 'max:255'],
            'course_code' => ['required', 'string', 'max:255', 'unique:' . Course::class],
            'course_duration' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'passed_subject' => ['string'],
            'credits' => ['string'],
            'faculty' => ['required', 'integer', 'min:1'],
            'pass' => ['integer', 'min:0'],
            'credit_amount' => ['integer', 'min:0'],
            'description' => ['required', 'string', 'max:1000'],
            'requirements' => ['required', 'string', 'max:1000'],
        ]);

        $course = Course::create([
            ...$validated,
            "faculty_id" => $request->faculty
        ]);

        if (Auth::user()->admin) {
            return redirect('/ad/course')->with('status', 'course-created');
        }

        return Redirect::route('course.show', $course->id)->with('status', 'course-created');
    }

    public function edit(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        if (Gate::denies('action-on-course', $id)) {
            return redirect('/dashboard');
        }

        $faculties = Auth::user()?->institute?->faculty;
        return view('course.edit', [
            'course' => $course,
            'faculties' => $faculties
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $course = Course::findOrFail($id);

        if (!Auth::user()?->admin) {
            if (Gate::denies('action-on-course', $id)) {
                return redirect('/dashboard');
            }
        }

        $request->validate([
            'course_name' => ['required', 'string', 'max:255'],
            'course_code' => ['required', 'string', 'max:255'],
            'course_duration' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'passed_subject' => ['string'],
            'credits' => ['string'],
            'faculty' => ['required', 'integer', 'min:1'],
            'pass' => ['integer', 'min:0'],
            'credit_amount' => ['integer', 'min:0'],
            'description' => ['required', 'string', 'max:1000'],
            'requirements' => ['required', 'string', 'max:1000'],
        ]);

        $course->update([
            'course_name' => $request->course_name,
            'course_code' => $request->course_code,
            'course_duration' => $request->course_duration,
            'price' => $request->price,
            'description' => $request->description,
            'passed_subject' => $request->passed_subject,
            'pass' => $request->pass,
            'credits' => $request->credits,
            'faculty_id' => $request->faculty,
            'level' => $request->level,
            'credit_amount' => $request->credit_amount,
            'requirements' => $request->requirements,
        ]);

        if (Auth::user()?->admin) {
            return redirect("/ad/course/$course->id")->with('status', 'course-updated');
        }

        return Redirect::route('course.show', $course->id)->with('status', 'course-updated');
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        if (!Auth::user()?->admin) {
            if (Gate::denies('action-on-course', $id)) {
                return redirect('/dashboard');
            }
        }

        $course = Course::findOrFail($id);
        $course->delete();

        if (Auth::user()?->admin) {
            return redirect('/ad/course')->with('status', 'course-deleted');
        }

        return Redirect::route('courses')->with('status', 'course-deleted');
    }
}
