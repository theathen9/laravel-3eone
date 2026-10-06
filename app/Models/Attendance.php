<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'tblAttendances';

    protected $primaryKey = 'attendance_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'enrollment_id',
        'attendance_date',
        'status',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(
            Enrollment::class,
            'enrollment_id',
            'enrollment_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'created_by',
            'employee_id'
        );
    }
}
