<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
      "course_name",
      "course_code" ,
      "course_duration",
      "price" ,
      "description",
      "requirements",
      "faculty_id",
      "pass",
      "credit_amount",
      "passed_subject",
      "credits",
      "level"
    ];
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
  public function application(): HasMany
  {
    return $this->hasMany(Application::class);
  }
}
