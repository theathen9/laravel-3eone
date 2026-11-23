<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $table = 'tblBranches';

    protected $primaryKey = 'branch_id';

    public $timestamps = false;

    protected $fillable = [
        'branch_code',
        'branch_name',
        'phones',
        'email',
        'address',
        'location',
        'status',
        'created_at',
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'phones' => 'array',
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(
            BranchHistory::class,
            'branch_id',
            'branch_id'
        )->orderByDesc('recorded_at');
    }
}
