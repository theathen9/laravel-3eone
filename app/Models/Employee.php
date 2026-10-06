<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    protected $table = 'tblEmployees';

    protected $primaryKey = 'employee_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'department_id',
        'position_id',

        'first_name_kh',
        'last_name_kh',
        'first_name_en',
        'last_name_en',

        'gender',
        'dob',

        'birth_village',
        'birth_commune',
        'birth_district',
        'birth_province',

        'curr_addr_village',
        'curr_addr_commune',
        'curr_addr_district',
        'curr_addr_province',

        'phone1',
        'phone2',
        'email',

        'profile_image',

        'hired_at',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'hired_at' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            Department::class,
            'department_id',
            'department_id'
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

    public function user(): HasOne
    {
        return $this->hasOne(
            User::class,
            'reference_id',
            'employee_id'
        );
    }
}
