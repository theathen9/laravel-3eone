<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $table = 'tblAcademicYears';

    protected $primaryKey = 'academic_year_id';

    public $timestamps = false;

    protected $fillable = [
        'academic_year',
        'start_date',
        'end_date',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'integer',
            'created_at' => 'datetime',
        ];
    }
}
