<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $table = 'tblInvoiceItems';

    protected $primaryKey = 'item_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'enrollment_id',
        'invoice_id',
        'description',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(
            Enrollment::class,
            'enrollment_id',
            'enrollment_id'
        );
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(
            Invoice::class,
            'invoice_id',
            'invoice_id'
        );
    }
}
