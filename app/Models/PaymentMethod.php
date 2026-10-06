<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $table = 'tblPaymentMethods';

    protected $primaryKey = 'method_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'method_name',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(
            Payment::class,
            'payment_method_id',
            'method_id'
        );
    }
}
