<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Institute extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'email',
        'phone',
        'user_id',
        'institute_name',
    ];

    /**
     * Get the user that owns the institute.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the faculties for the institute.
     */
    public function faculties(): HasMany
    {
        return $this->hasMany(Faculty::class);
    }

    /**
     * Get the control record associated with the institute.
     */
    public function control(): HasOne
    {
        return $this->hasOne(Control::class);
    }
}
