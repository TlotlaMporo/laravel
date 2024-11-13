<?php

namespace Database\Seeders;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Database\Seeder;

class InstitutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        $user = User::find(1); // Assuming user ID 1 is Admin User

        // Institute 1: National University of Lesotho
        $user->institute()->create([
            'institute_name' => 'National University of Lesotho',
            'email' => 'info@nul.ac.ls',
            'phone' => '2221-1293',
            'location' => 'Roma, Lesotho',
        ]);

        // Institute 2: Lesotho Polytechnic
        $user->institute()->create([
            'institute_name' => 'Lesotho Polytechnic',
            'email' => 'info@lpt.edu.ls',
            'phone' => '2231-2153',
            'location' => 'Maseru, Lesotho',
        ]);

        // Institute 3: Botho University (Lesotho campus)
        $user->institute()->create([
            'institute_name' => 'Botho University',
            'email' => 'info@botho.edu.ls',
            'phone' => '5222-0000',
            'location' => 'Maseru, Lesotho',
        ]);
    }
}
