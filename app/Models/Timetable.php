<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    protected $table = 'tblTimetables';

    protected $primaryKey = 'timetable_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'class_id',
        'day_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(
            ClassModel::class,
            'class_id',
            'class_id'
        );
    }

    public function day(): BelongsTo
    {
        return $this->belongsTo(
            Day::class,
            'day_id',
            'day_id'
        );
    }
}
