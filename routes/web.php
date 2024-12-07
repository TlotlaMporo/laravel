<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Models\Admin;
use App\Models\Admission;
use App\Models\Application;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Institute;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('home');
});

Route::get('/courses', [CourseController::class,'index'])->name('courses');
Route::get('/institutes', [InstituteController::class,'index'])->name('institutes');
Route::post('/apply/course/{id}', [ApplicationController::class, 'apply'])->name('apply.course');

Route::middleware('auth')->group(function () {
    Route::get('apply/{id}', [ApplicationController::class, 'create']);
    Route::post('apply/{id}', [ApplicationController::class, 'store']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        $institute_count = Institute::count();
        $faculty_count = Faculty::count();
        $course_count = Course::count();
        $student_count = Student::count();
        $applications_count = Application::count();
        $admissions_count = Admission::count();
    
        if (Auth::user()->admin) {
            return view('admin.dashboard', compact('institute_count', 'faculty_count', 'course_count', 'student_count', 'applications_count', 'admissions_count'));
        }
    
        if (Gate::allows('institute')) {
            $institute = Auth::user()->institute;
            $courses = $institute->faculty->flatMap->course ?? collect(); 
            $institute_applications = collect($courses->flatMap->application ?? []); 
            $admissions = $institute_applications->pluck('admission')->filter(); 
            

        
            return view('dashboard', compact('courses', 'institute_applications', 'admissions'));
        }
        Route::middleware(['auth'])->group(function() {
        // Dashboard route
         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        });
            Route::get('/institute/dashboard', [DashboardController::class, 'institutionDashboard'])->middleware('auth');

    
        if (Gate::allows('student')) {
            // Fetch applications for the logged-in student
            $student_applications = Auth::user()->student->application ?? collect();
    
            // Count unique courses and institutes from applications
            $courses_count = $student_applications->unique('course_id')->count();
            $institutes_count = $student_applications->unique('course.faculty.institute_id')->count();
    
            return view('dashboard', compact('student_applications', 'courses_count', 'institutes_count'));
        }
    })->name('dashboard');
    
    // Profile routes
    Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile',  'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Faculty routes
    Route::controller(FacultyController::class)->group(function(){
        Route::get('/faculty', 'create')->name('faculty');
        Route::post('/create-faculty', 'store')->name('create-faculty');
        Route::patch('/faculty/{id}/update', 'update')->name('faculty.update');
        Route::get('/faculty/{id}/edit','edit')->name('faculty.edit');
        Route::delete('/faculty/{id}','destroy')->name('faculty.destroy');  
    });

    // Course routes
    Route::controller(CourseController::class)->group(function(){
        Route::get('/course/create', 'create')->name('course.create');
        Route::get('/course/{id}',  'show')->name('course.show');
        Route::get('/course/{id}/edit', 'edit')->name('course.edit');
        Route::patch('/course/{id}/update',  'update')->name('course.update');
        Route::delete('/course/{id}', 'destroy')->name('course.destroy');
        Route::post('/create-course', 'store')->name('create-course'); 
        Route::post('/courses', [CourseController::class, 'store'])->name('course.store');
    });

    // Application routes
    Route::controller(ApplicationController::class)->group(function(){
        Route::get('/course/{id}/apply', 'create')->name('application.create');
        Route::post('/course/{id}/apply',  'store')->name('application.store');  // Adjusted this to match the 'store' method for handling POST
        Route::get('/applications', 'index')->name('application.index');
        Route::get('/applications/{id}', 'show')->name('application.show');   
    });

    // Admission routes
    Route::patch('/applications/{id}', [AdmissionController::class, 'store'])->name('application.update');
    Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions');

    // Control route
    Route::patch('/control/{id}', [ControlController::class, 'update'])->name('control.update');

    // Admin-specific routes
    Route::prefix('ad')->middleware('can:admin')->group(function () {
        Route::get('/course', function(){
            return view('admin.course.course', [
                'courses' => Course::with('faculty')->paginate(3),
                'institutes' => Institute::all(),
                'faculties' => Faculty::all()
            ]);
        });

        Route::get('/institute', function(){
            $institutes = Institute::with('faculty')->paginate(10);
            $courses_count = $institutes->map(fn($institute) => $institute->faculty->flatMap->course->count());
            return view('admin.institutes.index', compact('institutes', 'courses_count'));
        });

        Route::get('/faculty', function(){
            return view('admin.faculty.faculty', [
                'faculties' => Faculty::with('course')->paginate(3),
                'institutes' => Institute::all()
            ]);
        });

        Route::get('/applications', [ApplicationController::class, 'index']);
        Route::get('/admissions', [AdmissionController::class, 'index']);
        Route::get('/applications/{id}', [ApplicationController::class, 'show']);
        Route::get('/institute/{id}', [InstituteController::class, 'show']);
        
        Route::get('/faculty/{id}/edit', function($id){
            $faculty = Faculty::findOrFail($id);
            return view('admin.faculty.edit', compact('faculty'));
        });

        Route::get('/course/{id}/edit', function($id){
            $course = Course::findOrFail($id);
            return view('admin.course.edit', [
                'course' => $course,
                'faculties' => Faculty::all()
            ]);
        });

        Route::get('/course/{id}', function($id){
            $course = Course::findOrFail($id);
            return view('admin.course.show', compact('course'));
        });

        Route::get('/create', function(){
            return view('auth.admin', ['admins' => Admin::with('user')->paginate(3)]);
        });

        Route::delete('/admin/{id}', function($id){
            $admin = Admin::findOrFail($id);
            $admin->user->delete();
            return redirect('/ad/create');
        });

        Route::delete('/institute/{id}', function($id){
            $institute = Institute::findOrFail($id);
            $institute->user->delete();
            return redirect('/ad/institute');
        });

        Route::get('/profile', function(){
            return view('admin.profile', ['user' => Auth::user()]);
        })->name('admin.profile');
    });
});

require __DIR__.'/auth.php';
