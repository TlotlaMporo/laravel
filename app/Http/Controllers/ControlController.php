<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Gate;
use Illuminate\Http\Request;
use Auth;
use Redirect;

class ControlController extends Controller
{
    public function update(Request $request,$id){
        Gate::authorize('admin-institute');
        $institute = Institute::findOrFail($id);
        $control = $institute->control;

        if ($request->action==='application') {
            if ($control->applications==='close') {
            $control->applications = 'open';
            $control->save();
            } else {
                $control->applications = 'close';
                $control->save();
            }
            if (Auth::user()?->admin) {
                return redirect("/ad/institute/$institute->id")->with('status', "application-$control->applications");
            }
            return Redirect::route('application.index')->with('status', "application-$control->applications");
        }

        if ($request->action==='admission') {
            if ($control->admissions==='close') {
            $control->admissions = 'open';
            $control->save();
            } else {
                $control->admissions = 'close';
                $control->save();
            }
            if (Auth::user()?->admin) {
                return redirect("/ad/institute/$institute->id")->with('status', "application-$control->applications");
            }

            return Redirect::route('application.index')->with('status', 'admission-published');
        }
    }
}
