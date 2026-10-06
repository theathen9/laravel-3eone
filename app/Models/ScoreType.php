<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScoreType extends Model
{
    protected $table = 'tblScoreTypes';

    protected $primaryKey = 'score_type_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'score_type_name',
        'percentage',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];

    public function scores(): HasMany
    {
        return $this->hasMany(
            Score::class,
            'score_type_id',
            'score_type_id'
        );
    }
}
