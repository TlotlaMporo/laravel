<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Faculty;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // National University of Lesotho
        $faculty = Faculty::where('faculty_name', 'Faculty of Education')->first();
        $faculty->courses()->create([
            'course_name' => 'Bachelor of Education',
            'course_code' => 'EDU101',
            'course_duration' => '4 years',
            'price' => '5000',
            'description' => 'Bachelor degree for aspiring teachers.',
            'requirements' => 'High School diploma, English',
            'passed_subject' => 'English',
            'pass' => 60,
            'credit_amount' => 120,
            'credits' => '120',
            'level' => 'Undergraduate',
        ]);

        $faculty = Faculty::where('faculty_name', 'Faculty of Social Sciences')->first();
        $faculty->courses()->create([
            'course_name' => 'Bachelor of Arts in Sociology',
            'course_code' => 'SOC101',
            'course_duration' => '3 years',
            'price' => '4500',
            'description' => 'Study of human societies and cultures.',
            'requirements' => 'High School diploma',
            'passed_subject' => 'Sociology',
            'pass' => 60,
            'credit_amount' => 120,
            'credits' => '120',
            'level' => 'Undergraduate',
        ]);

        // Lesotho Polytechnic
        $faculty = Faculty::where('faculty_name', 'Faculty of Engineering')->first();
        $faculty->courses()->create([
            'course_name' => 'Bachelor of Civil Engineering',
            'course_code' => 'CIV101',
            'course_duration' => '5 years',
            'price' => '7000',
            'description' => 'Study of civil engineering principles and practices.',
            'requirements' => 'High School diploma, Mathematics, Physics',
            'passed_subject' => 'Mathematics',
            'pass' => 60,
            'credit_amount' => 150,
            'credits' => '150',
            'level' => 'Undergraduate',
        ]);

        $faculty = Faculty::where('faculty_name', 'Faculty of Information Technology')->first();
        $faculty->courses()->create([
            'course_name' => 'Bachelor of Information Technology',
            'course_code' => 'IT101',
            'course_duration' => '4 years',
            'price' => '6000',
            'description' => 'Study of computer science and IT systems.',
            'requirements' => 'High School diploma, Mathematics',
            'passed_subject' => 'Computer Science',
            'pass' => 60,
            'credit_amount' => 120,
            'credits' => '120',
            'level' => 'Undergraduate',
        ]);

        // Botho University
        $faculty = Faculty::where('faculty_name', 'Faculty of Business and Management')->first();
        $faculty->courses()->create([
            'course_name' => 'Bachelor of Business Administration',
            'course_code' => 'BBA101',
            'course_duration' => '4 years',
            'price' => '6500',
            'description' => 'Business administration and management principles.',
            'requirements' => 'High School diploma, Mathematics',
            'passed_subject' => 'Business Studies',
            'pass' => 60,
            'credit_amount' => 120,
            'credits' => '120',
            'level' => 'Undergraduate',
        ]);

        $faculty = Faculty::where('faculty_name', 'Faculty of Computing and IT')->first();
        $faculty->courses()->create([
            'course_name' => 'Bachelor of Computer Science',
            'course_code' => 'CS101',
            'course_duration' => '4 years',
            'price' => '7000',
            'description' => 'Study of computer science fundamentals and applications.',
            'requirements' => 'High School diploma, Mathematics',
            'passed_subject' => 'Computer Science',
            'pass' => 60,
            'credit_amount' => 120,
            'credits' => '120',
            'level' => 'Undergraduate',
        ]);
    }
}
