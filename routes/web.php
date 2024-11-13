<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\ProfileController;
use App\Models\Admin;
use App\Models\Admission;
use App\Models\Application;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Institute;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/courses', [CourseController::class,'index'])->name('courses');
Route::get('/institutes', [InstituteController::class,'index'])->name('institutes');



Route::get('/dashboard', function () {
    //dd();
    $institute_count = count(Institute::all());
    $faculty_count = count(Faculty::all());
    $course_count = count(Course::all());
    $student_count = count(Student::all());
    $applications_count = count(Application::all());
    $admissions_count = count(Admission::all());
    
    if (Auth::user()->admin) {
        return view('admin.dashboard',[
            "institute_count"=>$institute_count,
            "faculty_count"=>$faculty_count,
            "course_count"=>$course_count,
            "student_count"=>$student_count,
            "applications_count"=>$applications_count,
            "admissions_count"=>$admissions_count,
        ]);
    }
    if (Gate::allows('institute')) {
        $institute = Auth::user()->institute;
        $courses = [];
        $institute_applications = [];
        $admissions = [];
   
        // Ensure $institute->faculty is a valid collection before looping
        if ($institute->faculty && $institute->faculty->isNotEmpty()) {
            foreach ($institute->faculty as $faculty) {
                // Check if the faculty has courses before adding them
                if ($faculty->course && $faculty->course->isNotEmpty()) {
                    array_push($courses, $faculty->course);
                }
            }
        }
   
        // Proceed only if courses are not empty
        if (!empty($courses)) {
            foreach ($courses as $course_in_faculty) {
                if ($course_in_faculty && $course_in_faculty->isNotEmpty()) {
                    foreach ($course_in_faculty as $course) {
                        if ($course->application && $course->application->isNotEmpty()) {
                            foreach ($course->application as $app) {
                                array_push($institute_applications, $app);
                                if ($app->admission) {
                                    array_push($admissions, $app->admission);
                                }
                            }
                        }
                    }
                }
            }
        }
   
        return view('dashboard', [
            'courses' => $courses,
            'applications' => $institute_applications,
            'admissions' => $admissions
        ]);
    }
   
    if (Gate::allows('student')) {
        $student_institutes = [];
        
        // Check if applications are not null
        $student_applications = Auth::user()->student->application;
        if ($student_applications) {
            $student_applications = iterator_to_array($student_applications);
    
            foreach ($student_applications as $app) {
                if (!in_array($app->course->faculty->institute->id, $student_institutes)) {
                    array_push($student_institutes, $app->course->faculty->institute->id);
                }
            }
        }
        
        return view('dashboard', ['student_institutes' => $student_institutes]);
    }

    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile',  'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
    

    Route::controller(FacultyController::class)->group(function(){
        Route::get('/faculty', 'create')->name('faculty');
        Route::post('/create-faculty', 'store')->name('create-faculty');
        Route::patch('/faculty/{id}/update', 'update')->name('faculty.update');
        Route::get('/faculty/{id}/edit','edit')->name('faculty.edit');
        Route::delete('/faculty/{id}','destroy')->name('faculty.destroy');  
    });
    
    Route::controller(CourseController::class)->group(function(){
        Route::get('/course/create', 'create')->name('course.create');
        Route::get('/course/{id}',  'show')->name('course.show');
        Route::get('/course/{id}/edit', 'edit')->name('course.edit');
        Route::patch('/course/{id}/update',  'update')->name('course.update');
        Route::delete('/course/{id}', 'destroy')->name('course.destroy');
        Route::post('/create-course', 'store')->name('create-course'); 
    });

    Route::controller(ApplicationController::class)->group(function(){
        Route::get('/course/{id}/apply', 'create')->name('application.create');
        Route::post('/course/{id}/apply',  'store')->name('application.store');
        Route::get('/applications', 'index')->name('application.index');
        Route::get('/applications/{id}', 'show')->name('application.show');   
    });
    
    Route::patch('/applications/{id}', [AdmissionController::class, 'store'])->name('application.update');
    Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions');

    Route::patch('/control/{id}', [ControlController::class, 'update'])->name('control.update');

    Route::get('/ad/course', function(){
        return view('admin.course.course', [
            'courses' => Course::with('faculty')->paginate(3), 'institutes' => Institute::all(), 
            'faculties' => Faculty::all()
        ]);
    });
    Route::get('/ad/institute', function(){
        $institutes = Institute::all();
        $courses_count = [];
        foreach($institutes as $institute) {
            $courses =[];
            foreach($institute->faculty as $faculty){
                if (count($faculty->course)>0) {
                    array_push($courses,$faculty->course);
                }  
            }  
            array_push($courses_count, count($courses));
        }
        return view('admin.institutes.index', [
            'institutes' => Institute::with('faculty')->paginate(10),'courses_count'=>$courses_count]);
    });
    Route::get('/ad/faculty', function(){
        return view('admin.faculty.faculty', ['faculties'=>Faculty::with('course')->paginate(3),'institutes' => Institute::all()]);
    });
    Route::get('/ad/applications', [ApplicationController::class,'index']);
    Route::get('/ad/admissions', [AdmissionController::class,'index']);
    Route::get('/ad/applications/{id}', [ApplicationController::class,'show']);
    Route::get('/ad/institute/{id}', [InstituteController::class,'show']);
    Route::get('/ad/faculty/{id}/edit', function($id){
        $faculty = Faculty::findOrFail($id);
        return view('admin.faculty.edit', ['faculty'=>$faculty]);
    });
    Route::get('/ad/course/{id}/edit', function($id){
        $course = Course::findOrFail($id);
        return view('admin.course.edit', ['course'=>$course,'faculties'=>Faculty::all()]);
    });
    Route::get('/ad/course/{id}', function($id){
        $course = Course::findOrFail($id);
        return view('admin.course.show', ['course'=>$course]);
    });

    Route::get('/ad/create', function(){
        return view('auth.admin', ['admins' => Admin::with('user')->paginate(3)]);
    });
    Route::delete('/admin/{id}', function($id){
        Gate::authorize('admin');
        $admin = Admin::findOrFail($id);
        $admin->user->delete();
        return redirect('/ad/create');
    });
    
    Route::delete('/ad/institute/{id}', function($id){
        Gate::authorize('admin');
        $institute = Institute::findOrFail($id);
        $institute->user->delete();
        return redirect('/ad/institute');
    });

    Route::get('/ad/profile', function(){
        return view('admin.profile', ['user' =>Auth::user()]);
    })->name('edit');
});

require __DIR__.'/auth.php';
