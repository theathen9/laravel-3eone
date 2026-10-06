<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    protected $table = 'tblGrades';

    protected $primaryKey = 'grade_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'grade_name',
        'min_average',
        'max_average',
        'remark',
    ];

    protected $casts = [
        'min_average' => 'decimal:2',
        'max_average' => 'decimal:2',
    ];

    public function studentResults(): HasMany
    {
        return $this->hasMany(
            StudentResult::class,
            'grade_id',
            'grade_id'
        );
    }
}
