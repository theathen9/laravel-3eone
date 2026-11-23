<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeBranchHistory extends Model
{
    protected $table = 'tblEmployeeBranchHistory';

    protected $primaryKey = 'employee_branch_history_id';

    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'branch_id',
        'branch_code',
        'branch_name',
        'start_date',
        'end_date',
        'remarks',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'recorded_at' => 'datetime',
        ];
    }

    public function toArray(): array
    {
        $attributes = parent::toArray();

        foreach (['start_date', 'end_date'] as $dateField) {
            $attributes[$dateField] = $this->{$dateField}?->format('Y-m-d');
        }

        return $attributes;
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id',
            'employee_id'
        );
    }
}
