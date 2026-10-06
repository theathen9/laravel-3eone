<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSubject extends Model
{
    protected $table = 'tblEmployeeSubjects';

    protected $primaryKey = 'employee_subject_id';

    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'subject_id',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id',
            'employee_id'
        );
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(
            Subject::class,
            'subject_id',
            'subject_id'
        );
    }
}
