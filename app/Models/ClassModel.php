<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'tblClasses';

    protected $primaryKey = 'class_id';

    public $timestamps = false;

    protected $fillable = [
        'class_name',
        'class_code',
        'course_id',
        'academic_year',
        'max_students',
        'current_students',
        'status',
        'teacher_id',
        'room_id',
        'slot_id',
    ];

    protected $casts = [
        'max_students' => 'integer',
        'current_students' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(
            Course::class,
            'course_id',
            'course_id'
        );
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'teacher_id',
            'employee_id'
        );
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(
            Room::class,
            'room_id',
            'room_id'
        );
    }

    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(
            TimeSlot::class,
            'slot_id',
            'slot_id'
        );
    }

    public function timetables(): HasMany
    {
        return $this->hasMany(
            Timetable::class,
            'class_id',
            'class_id'
        );
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(
            Enrollment::class,
            'class_id',
            'class_id'
        );
    }
}
