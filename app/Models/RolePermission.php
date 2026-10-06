<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Role;

class RolePermission extends Model
{
    protected $table = 'tblRolePermissions';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'role_id',
        'permission_id',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(
            Role::class,
            'role_id',
            'role_id'
        );
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(
            Permission::class,
            'permission_id',
            'permission_id'
        );
    }
}
