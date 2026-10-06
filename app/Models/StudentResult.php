<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentResult extends Model
{
    protected $table = 'tblStudentResults';

    protected $primaryKey = 'result_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'class_id',
        'academic_year',
        'total_score',
        'average_score',
        'grade_id',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
        'average_score' => 'decimal:2',
    ];

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
            SchoolClass::class,
            'class_id',
            'class_id'
        );
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(
            Grade::class,
            'grade_id',
            'grade_id'
        );
    }
}
