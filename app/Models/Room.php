<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'tblRooms';

    protected $primaryKey = 'room_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'room_name',
        'capacity',
        'status',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'status' => 'integer',
    ];
}
