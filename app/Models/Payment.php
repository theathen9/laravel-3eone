<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'tblPayments';

    protected $primaryKey = 'payment_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'payment_date',
        'amount',
        'payment_method_id',
        'reference_no',
        'created_by',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(
            Invoice::class,
            'invoice_id',
            'invoice_id'
        );
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(
            PaymentMethod::class,
            'payment_method_id',
            'method_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'created_by',
            'employee_id'
        );
    }
}
