<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $table = 'tblScores';

    protected $primaryKey = 'score_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'class_id',
        'score_type_id',
        'score',
        'academic_year',
        'semester',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'created_at' => 'datetime',
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

    public function scoreType(): BelongsTo
    {
        return $this->belongsTo(
            ScoreType::class,
            'score_type_id',
            'score_type_id'
        );
    }
}
