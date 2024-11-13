<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = Student::find(1); // Assuming student ID 1 is John Doe
        $course = Course::find(1); // Assuming course ID 1 is Web Development

        $student->applications()->create([
            'grades' => json_encode(['Math' => 'A', 'English' => 'B']),
            'status' => 'Pending',
            'course_id' => $course->id,
        ]);
    }
}
