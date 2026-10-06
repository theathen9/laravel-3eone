<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $table = 'tblPositions';

    protected $primaryKey = 'position_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'position_code',
        'position_name',
        'description',
        'status',
        'created_at',
    ];

    protected $casts = [
        'status' => 'integer',
        'created_at' => 'datetime',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(
            Employee::class,
            'position_id',
            'position_id'
        );
    }
}
