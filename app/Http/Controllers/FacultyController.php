<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;

class FacultyController extends Controller
{
    // Display the form and the list of faculties
    public function create(): View
    {
        if (Gate::denies('institute')) {
            return redirect('/dashboard');
        }

        // Fetch all faculties associated with the authenticated user's institute
        $faculties = Faculty::where('institute_id', Auth::user()->institute->id)->get();

        return view('faculty.faculty', ['faculties' => $faculties]);
    }

    // Handle the creation of a new faculty
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::user()?->admin) {
            if (Gate::denies('institute')) {
                abort(404);
            }

            // Validate input
            $validated = $request->validate([
                'faculty_name' => ['required', 'string', 'max:255', 'unique:faculties'],
            ]);

            // Create the faculty
            Faculty::create([
                'faculty_name' => $validated['faculty_name'],
                'institute_id' => Auth::user()->institute->id,
            ]);
        } else {
            $validated = $request->validate([
                'faculty_name' => ['required', 'string', 'max:255', 'unique:faculties'],
                'institute' => ['required', 'integer'],
            ]);

            Faculty::create([
                'faculty_name' => $validated['faculty_name'],
                'institute_id' => $request->institute,
            ]);

            return redirect('ad/faculty')->with('status', 'Faculty created successfully!');
        }

        return Redirect::route('faculty')->with('status', 'Faculty created successfully!');
    }

    // Display the edit form for a specific faculty
    public function edit(Request $request, $id): View
    {
        if (Gate::denies('action-on-faculty', $id)) {
            abort(401);
        }

        $faculty = Faculty::findOrFail($id);
        return view('faculty.edit', ['faculty' => $faculty]);
    }

    // Update a specific faculty
    public function update(Request $request, $id): RedirectResponse
    {
        if (!Auth::user()->admin) {
            if (Gate::denies('action-on-faculty', $id)) {
                abort(401);
            }
        }

        // Validate input
        $request->validate([
            'faculty_name' => ['required', 'string', 'max:255', 'unique:faculties'],
        ]);

        // Find and update the faculty
        $faculty = Faculty::findOrFail($id);
        $faculty->faculty_name = $request->faculty_name;
        $faculty->save();

        if (Auth::user()->admin) {
            return redirect('ad/faculty')->with('status', 'Faculty updated successfully!');
        }

        return Redirect::route('faculty')->with('status', 'Faculty updated successfully!');
    }

    // Delete a specific faculty
    public function destroy(Request $request, $id): RedirectResponse
    {
        if (!Auth::user()->admin) {
            if (Gate::denies('action-on-faculty', $id)) {
                abort(401);
            }
        }

        $faculty = Faculty::findOrFail($id);
        $faculty->delete();

        if (Auth::user()->admin) {
            return redirect('ad/faculty')->with('status', 'Faculty deleted successfully!');
        }

        return Redirect::route('faculty')->with('status', 'Faculty deleted successfully!');
    }
}
