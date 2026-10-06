<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $table = 'tblDepartments';

    protected $primaryKey = 'department_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'department_code',
        'department_name',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(
            Employee::class,
            'department_id',
            'department_id'
        );
    }
}
