<?php

use App\Models\Course;
use App\Models\student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->json('grades');
            $table->string('status');
            $table->foreignIdFor(Course::class, 'course_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(student::class, 'student_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
