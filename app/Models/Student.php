<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $table = 'tblStudents';

    protected $primaryKey = 'student_id';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'student_code',

        'first_name_kh',
        'last_name_kh',

        'first_name_en',
        'last_name_en',

        'gender',
        'dob',

        'birth_addr_village',
        'birth_addr_commune',
        'birth_addr_district',
        'birth_addr_province',

        'curr_addr_village',
        'curr_addr_commune',
        'curr_addr_district',
        'curr_addr_province',

        'phone1',
        'phone2',

        'email',
        'profile_image',

        'academic_year',
        'register_at',

        'guardian1_name',
        'guardian2_name',

        'guardian1_relationship',
        'guardian2_relationship',

        'guardian_curr_addr_village',
        'guardian_curr_addr_commune',
        'guardian_curr_addr_district',
        'guardian_curr_addr_province',

        'guardian1_phone',
        'guardian2_phone',

        'guardian_email',

        'created_by',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'register_at' => 'date',
        'created_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'created_by',
            'employee_id'
        );
    }
}
