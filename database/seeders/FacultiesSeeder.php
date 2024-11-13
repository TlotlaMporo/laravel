<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Institute;
use Illuminate\Database\Seeder;

class FacultiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // National University of Lesotho
        $institute = Institute::where('institute_name', 'National University of Lesotho')->first();
        $institute->faculties()->create([
            'faculty_name' => 'Faculty of Education',
        ]);
        $institute->faculties()->create([
            'faculty_name' => 'Faculty of Social Sciences',
        ]);
        $institute->faculties()->create([
            'faculty_name' => 'Faculty of Law',
        ]);
        
        // Lesotho Polytechnic
        $institute = Institute::where('institute_name', 'Lesotho Polytechnic')->first();
        $institute->faculties()->create([
            'faculty_name' => 'Faculty of Engineering',
        ]);
        $institute->faculties()->create([
            'faculty_name' => 'Faculty of Information Technology',
        ]);
        
        // Botho University
        $institute = Institute::where('institute_name', 'Botho University')->first();
        $institute->faculties()->create([
            'faculty_name' => 'Faculty of Business and Management',
        ]);
        $institute->faculties()->create([
            'faculty_name' => 'Faculty of Computing and IT',
        ]);
    }
}
