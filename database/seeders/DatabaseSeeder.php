<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Create the admin user
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@higherlearning.com',
            'password' => bcrypt('Admin@123')  // Make sure the password is encrypted
        ]);

        // Create the admin
        Admin::factory()->create([
            'user_id' => $user->id
        ]);

        // Call the other seeders
        $this->call([
            InstitutesSeeder::class,
            FacultiesSeeder::class,
            CoursesSeeder::class,
            StudentsSeeder::class,
            ApplicationsSeeder::class,
            AdmissionsSeeder::class,
            AdminsSeeder::class,
        ]);
    }
}
