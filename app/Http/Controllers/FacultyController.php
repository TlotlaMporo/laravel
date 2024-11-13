<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Auth;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;
use Redirect;
class FacultyController extends Controller
{
    public function create()
    {
        if (Gate::denies('institute')) {
            return redirect('/dashboard');
        }
        $faculties = Auth::user()?->institute?->faculty;
        return view('faculty.faculty',['faculties'=>$faculties]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if(!Auth::user()?->admin) {
            if (Gate::denies('institute')) {
                abort(404);
            }
            $validated = $request->validate([
                'faculty_name' => ['required', 'string', 'max:255', 'unique:' . Faculty::class],
            ]);

            Faculty::create([
                ...$validated,
                'institute_id' => Auth::user()->institute->id
            ]);
        } else{
            $validated = $request->validate([
                'faculty_name' => ['required', 'string', 'max:255', 'unique:' . Faculty::class],
                'institute' => ['required', 'integer'],
            ]);
            Faculty::create([
                ...$validated,
                'institute_id' =>$request->institute
            ]);
            return redirect('ad/faculty')->with('status', 'faculty-created');
        }
        
        

        return Redirect::route('faculty')->with('status', 'faculty-created');
    }
    public function edit(Request $request,$id)
    {
        if (Gate::denies('action-on-faculty',$id)) {
            abort(401);
        }

        $faculty = Faculty::find($id);
        return view('faculty.edit', [
            'faculty' => $faculty,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request,$id): RedirectResponse
    {
        if (!Auth::user()->admin) {
            if (Gate::denies('action-on-faculty', $id)) {
                abort(401);
            }
        }

        $request->validate([
            'faculty_name' => ['required', 'string', 'max:255', 'unique:' . Faculty::class],
        ]);

        $faculty = Faculty::findOrFail($id);
        $faculty->faculty_name = $request->faculty_name;

        $faculty->save();
        if (Auth::user()->admin) {
            return redirect('ad/faculty')->with('status', 'faculty-deleted');
        }

        return Redirect::route('faculty')->with('status', 'faculty-updated');

    }
    public function destroy(Request $request,$id): RedirectResponse
    {
        if (!Auth::user()->admin) {
            if (Gate::denies('action-on-faculty',$id)) {
                abort(401);
            }
        }
        
        $faculty = Faculty::findOrFail($id);
        $faculty->delete();

        if (Auth::user()->admin) {
            return redirect('ad/faculty')->with('status', 'faculty-deleted');
        }
        return Redirect::route('faculty')->with('status', 'faculty-deleted');

    }
}
