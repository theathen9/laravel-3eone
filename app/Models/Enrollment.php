<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $table = 'tblEnrollments';

    protected $primaryKey = 'enrollment_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'class_id',
        'price',
        'discount',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
            'student_id'
        );
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(
            ClassModel::class,
            'class_id',
            'class_id'
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
