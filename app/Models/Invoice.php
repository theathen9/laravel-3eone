<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $table = 'tblInvoices';

    protected $primaryKey = 'invoice_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'invoice_no',
        'student_id',
        'invoice_date',
        'total_amount',
        'created_by',
        'status',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
            'student_id'
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

    public function payments(): HasMany
    {
        return $this->hasMany(
            Payment::class,
            'invoice_id',
            'invoice_id'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            InvoiceItem::class,
            'invoice_id',
            'invoice_id'
        );
    }
}
