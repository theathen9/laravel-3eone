<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $table = 'tblCourses';

    protected $primaryKey = 'course_id';

    public $timestamps = false;

    protected $fillable = [
        'course_code',
        'course_name',
        'subject_id',
        'level_id',
        'price',
        'duration',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(
            Subject::class,
            'subject_id',
            'subject_id'
        );
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(
            Level::class,
            'level_id',
            'level_id'
        );
    }
    // public function classes(): HasMany
    // {
    //     return $this->hasMany(ClassModel::class, 'course_id', 'course_id');
    // }
}
