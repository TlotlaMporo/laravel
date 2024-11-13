<?php

namespace Database\Seeders;

use App\Models\Admission;
use App\Models\Application;
use Illuminate\Database\Seeder;

class AdmissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $application = Application::find(1); // Assuming application ID 1

        $application->admission()->create([]);
    }
}
