<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $table = 'tblTimeSlots';

    protected $primaryKey = 'slot_id';

    public $timestamps = false;

    protected $fillable = [
        'slot_name',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];
}
