<?php

use App\Models\Course;
use App\Models\Student;
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
            $table->unsignedBigInteger('user_id')->nullable(); // Adjust as needed
            $table->json('passed_subjects')->nullable(); // Add passed_subjects column
            $table->json('passed_grades')->nullable();   // Add passed_grades column
            $table->json('credit_subjects')->nullable(); // Add credit_subjects column
            $table->json('credit_grades')->nullable();   // Add credit_grades column
            $table->json('grades')->nullable();
            $table->string('status')->default('Pending');  // Set a default value
            $table->foreignIdFor(Course::class, 'course_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Student::class, 'student_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
