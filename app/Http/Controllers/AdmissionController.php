<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Application;
use Arr;
use Gate;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Redirect;

class AdmissionController extends Controller
{
    public function index()
    {
        $published_admissions = [];
        $student_published_admissions = [];
        $institute_published_admissions = [];

        // Fetch all admissions
        $admissions = Admission::all();

        // Filter admissions where application control is open
        foreach ($admissions as $admission) {
            // Ensure all relationships exist before accessing them
            if ($admission->application && 
                $admission->application->course && 
                $admission->application->course->faculty && 
                $admission->application->course->faculty->institute && 
                $admission->application->course->faculty->institute->control &&
                $admission->application->course->faculty->institute->control->admissions === 'open') {
                
                array_push($published_admissions, $admission);
            }
        }

        // Filter admissions based on the logged-in user's institute
        $institute_published_admissions = Arr::where($published_admissions, function ($admission) {
            return $admission->application->course->faculty->institute->id === Auth::user()?->institute?->id;
        });

        // Filter admissions based on the logged-in student's ID
        $student_published_admissions = Arr::where($published_admissions, function ($admission) {
            return $admission->application->student->id === Auth::user()?->student?->id;
        });

        // Apply different logic based on user role
        if (Gate::allows('student')) {
            $published_admissions = $student_published_admissions; // Only student-related admissions
        } elseif (Gate::allows('institute')) {
            $published_admissions = $institute_published_admissions; // Only institute-related admissions
        }

        // Return the appropriate view based on user role
        if (Gate::allows('admin')) {
            return view('admin.admissions.index', [
                'admissions' => $published_admissions
            ]);
        }

        return view('admissions.index', [
            'admissions' => $published_admissions
        ]);
    }

    public function store(Request $request, $id): RedirectResponse
    {
        Gate::authorize('admin-institute'); // Ensure the user has the appropriate permissions

        $application = Application::findOrFail($id);
        $student_applications = $application->student->application;

        // Check if the application is already admitted
        foreach ($student_applications as $app) {
            if ($app->status === 'admitted') {
                return Redirect::route('application.update', $id)->with('status', 'application-updated');
            }
        }

        // Fetch the admission for the application
        $admission = Admission::firstWhere('application_id', '=', $application->id);

        // Handle the admission actions based on the form submission
        if ($request->action === 'admit') {
            if (!$admission?->id) {
                $application->status = 'admitted';
                Admission::create([
                    "application_id" => $application->id
                ]);
                $application->save();
                return Redirect::route('application.update', $id)->with('status', 'application-admitted');
            } else {
                return Redirect::route('application.update', $id)->with('status', 'application-updated');
            }
        } elseif ($request->action === 'waitlist') {
            $application->status = 'waitlisted';
            $application->save();
            return Redirect::route('application.update', $id)->with('status', 'application-waitlisted');
        } else {
            $application->status = 'rejected';
            $application->save();
            return Redirect::route('application.update', $id)->with('status', 'application-rejected');
        }
    }
}
