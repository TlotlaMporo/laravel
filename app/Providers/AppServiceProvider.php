<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Faculty;
use App\Models\User;
use Auth;
use Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if (\Schema::hasTable('your_table')) {
            // Your super fun database stuff
        }
        Gate::define('student', function (User $user) {
            return $user->student;
        });

        Gate::define('institute', function (User $user) {
            return $user->institute;
        });
        Gate::define('admin', function (User $user) {
            return $user->admin;
        });
        Gate::define('admin-institute', function (User $user) {
            return $user->admin || $user->institute;
        });
        Gate::define('not-admin', function (?User $user) {
            return $user?->institute || $user?->student || Auth::guest();
        });

        Gate::define('action-on-course', function (User $user, $id) {
            $course = Course::findOrFail($id);
            return $course->faculty->institute->is($user->institute);
        });

        Gate::define('action-on-faculty', function (User $user, $id) {
            $faculty = Faculty::findOrFail($id);
            return $faculty->institute->is($user->institute);
        });
       
    }
}
