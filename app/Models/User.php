<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tblUsers';

    protected $primaryKey = 'user_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'reference_id',
        'reference_type',
        'username',
        'email',
        'password',
        'role_id',
        'status',
        'last_login',
        'reset_token',
        'reset_expiry',
        'public_id',
    ];

    protected $hidden = [
        'password',
        'reset_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status' => 'integer',
            'last_login' => 'datetime',
            'reset_expiry' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function role(): BelongsTo
    {
        return $this->belongsTo(
            Role::class,
            'role_id',
            'role_id'
        );
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(
            UserToken::class,
            'user_id',
            'user_id'
        );
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
