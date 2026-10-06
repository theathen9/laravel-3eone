<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $table = 'tblSubjects';

    protected $primaryKey = 'subject_id';

    public $timestamps = false;

    protected $fillable = [
        'subject_code',
        'subject_name',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(
            Course::class,
            'subject_id',
            'subject_id'
        );
    }
}
