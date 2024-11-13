<?php

use App\Models\Faculty;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string("course_name");
            $table->string("course_code");
            $table->string("course_duration");
            $table->string("price");
            $table->text("description");
            $table->text("requirements");
            $table->string("passed_subject");
            $table->integer("pass");
            $table->integer("credit_amount");
            $table->string("credits");
            $table->string("level");
            $table->foreignIdFor(Faculty::class, "faculty_id")->constrained()->cascadeOnDelete()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
