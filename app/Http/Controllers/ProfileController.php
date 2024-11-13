<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Institute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
            if($request->user()->student){
                $student = $request->user()->student;
                $student->email = $request->email;
                $student->save();
            }
            if($request->user()->institute){
                $institute = $request->user()->institute;
                $institute->email = $request->email;
                $institute->save();
            }  
        }
        if ($request->user()->isDirty('name')) {
            if ($request->user()->student) {
                $student = $request->user()->student;
                $student->full_name = $request->name;
                $student->save();
            }
            if ($request->user()->institute) {
                $institute = $request->user()->institute;
                $institute->institute_name = $request->name;
                $institute->save();
            }
        }
        $request->user()->save();

        if(Auth::user()?->admin){
            return redirect('/ad/profile')->with('status', 'profile-updated');  
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
