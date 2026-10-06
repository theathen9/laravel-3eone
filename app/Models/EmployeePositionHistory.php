<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeePositionHistory extends Model
{
    use HasFactory;

    protected $table = 'tblEmployeePositionHistory';

    protected $primaryKey = 'position_history_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'position_id',
        'department_id',
        'start_date',
        'end_date',
        'remarks',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'created_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function employee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id',
            'employee_id'
        );
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(
            Position::class,
            'position_id',
            'position_id'
        );
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            Department::class,
            'department_id',
            'department_id'
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
