<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $table = 'tblLevels';

    protected $primaryKey = 'level_id';

    public $timestamps = false;

    protected $fillable = [
        'level_name',
        'level_number',
    ];

    protected $casts = [
        'level_number' => 'integer',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(
            Course::class,
            'level_id',
            'level_id'
        );
    }
}
