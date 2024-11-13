<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Control;
use App\Models\Institute;
use App\Models\student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.student');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $register_as = $request->register_as; 
        
        if ($register_as && $register_as ==='student') {
            $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'national_id' => ['required', 'integer', 'min:0'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            student::create([
                'full_name' => $request->name,
                'email' => $request->email,
                'national_id' => $request->national_id,
                'phone' => $request->phone,
                'user_id' => $user->id,
            ]);

        } elseif($register_as && $register_as === 'institute') {
            $request->validate([
            'institute_name' => ['required', 'string', 'max:255', 'unique:' . Institute::class],
            'location' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->institute_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $insti = Institute::create([
                'institute_name' => $request->institute_name,
                'email' => $request->email,
                'location' => $request->location,
                'phone' => $request->phone,
                'user_id' => $user->id,
            ]);
            Control::create([
                "applications" =>"close",
                "admissions" =>"close",
                "institute_id"=>$insti->id
            ]);
            
        } elseif($register_as && $register_as === 'admin') {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            Admin::create([
                'user_id'=>$user->id
            ]);
            return redirect(route('dashboard', absolute: false));
        } else {
            return redirect(route('/', absolute: false));
        }

        
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
