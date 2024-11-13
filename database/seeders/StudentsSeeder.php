<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user with ID 2 exists, otherwise create it
        $user = User::find(2);

        if (!$user) {
            $user = User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password123'),
            ]);
        }

        // Create student for the user
        $user->student()->create([
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'national_id' => '123456789012',
        ]);
    }
}
