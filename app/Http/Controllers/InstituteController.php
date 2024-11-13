<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Arr;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstituteController extends Controller
{
    public function index(): View
    {
        $institutes = Institute::all();

        return view('institute.index', ['institutes' => $institutes]);
    }
    public function show($id): View
    {
        $institute = Institute::findOrFail($id);
        $courses = [];
        $institute_applications = [];
        foreach ($institute->faculty as $faculty) {
            if (count($faculty->course) > 0)
                array_push($courses, $faculty->course);
        }

        foreach ($courses as $course_in_faculty) {
            foreach ($course_in_faculty as $course) {
                foreach ($course->application as $app) {
                    if (count($course->application) > 0) {
                        array_push($institute_applications, $app);
                    }
                }
            }
        }
        $applications = Arr::where($institute_applications,function($app){
            return $app->status === 'admitted';
        });

        return view('admin.institutes.show', ['institute' => $institute,'applications'=>$applications]);
    }
}
