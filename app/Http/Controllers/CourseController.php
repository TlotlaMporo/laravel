<?php

namespace App\Http\Controllers;

use App\Models\Course;
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

        $faculties = Auth::user()?->institute?->faculty;
        $courses = Course::with('faculty')->paginate(5);
        
        return view('course.create',['faculties'=>$faculties,'courses'=>$courses]);
    }
    public function show($id):View
    {
        $faculties = Auth::user()?->institute?->faculty;
        $course = Course::findOrFail($id);
        
        return view('course.show',['faculties'=>$faculties,'course'=>$course]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

        
        if(Gate::denies('action-on-course',$id)){
           return redirect('/dashboard');
        }

        $faculties = Auth::user()?->institute?->faculty;
        return view('course.edit', [
            'course' => $course,
            'faculties'=> $faculties
        ]);
    }
    /**
     * Update the user's profile information.
     */
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

        

        $course->course_name= $request->course_name;
        $course->course_code= $request->course_code;
        $course->course_duration= $request->course_duration;
        $course->price= $request->price;
        $course->description= $request->description;
        $course->passed_subject= $request->passed_subject;
        $course->pass= $request->pass;
        $course->credits= $request->credits;
        $course->faculty_id = $request->faculty;
        $course->level= $request->level;
        $course->credit_amount= $request->credit_amount;
        $course->requirements= $request->requirements;

        $course->save();
        if (Auth::user()?->admin) {
            return redirect("/ad/course/$course->id")->with('status', 'course-updated');
        }
        return Redirect::route('course.show',$course->id)->with('status', 'course-updated');

    }
    public function destroy(Request $request, $id): RedirectResponse
    {
        if(!Auth::user()?->admin){
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
