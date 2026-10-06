<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $table = 'tblDays';

    protected $primaryKey = 'day_id';

    public $timestamps = false;

    protected $fillable = [
        'day_code',
        'day_name',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}
