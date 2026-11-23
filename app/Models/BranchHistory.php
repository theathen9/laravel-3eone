<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchHistory extends Model
{
    protected $table = 'tblBranchHistory';

    protected $primaryKey = 'branch_history_id';

    public $timestamps = false;

    protected $fillable = [
        'branch_id',
        'action',
        'branch_code',
        'branch_name',
        'phones',
        'email',
        'address',
        'location',
        'status',
        'recorded_at',
    ];

    protected $casts = [
        'phones' => 'array',
        'status' => 'boolean',
        'recorded_at' => 'datetime',
    ];
}
