<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    private const INVOICEABLE_STATUSES = ['PAID', 'PARTIAL'];

    public function isInvoiceable(Invoice $invoice): bool
    {
        if (! in_array(
            strtoupper((string) $invoice->status),
            self::INVOICEABLE_STATUSES,
            true
        )) {
            return false;
        }

        $invoice->loadMissing('payments');

        return $invoice->payments->contains(
            fn ($payment) => strtoupper((string) $payment->status) === 'COMPLETED'
                && (float) $payment->amount > 0
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function viewData(Invoice $invoice, bool $forPdf = false): array
    {
        $invoice->load([
            'student',
            'creator',
            'payments.paymentMethod',
            'items.enrollment.class.course',
            'items.enrollment.class.teacher',
            'items.enrollment.class.room',
            'items.enrollment.class.timeSlot',
            'items.enrollment.class.timetables.day',
        ]);

        $classes = $invoice->items
            ->map(fn ($item) => $item->enrollment?->class)
            ->filter();

        $total = (float) $invoice->total_amount;
        $subtotal = (float) $invoice->items->sum(
            fn ($item) => (float) $item->amount
        );
        $paid = (float) $invoice->payments
            ->filter(fn ($payment) => strtoupper((string) $payment->status) === 'COMPLETED')
            ->sum(fn ($payment) => (float) $payment->amount);
        $preparedBySignature = null;
        $signaturePath = $invoice->creator?->signature_image;

        if ($signaturePath && Storage::disk('public')->exists($signaturePath)) {
            $preparedBySignature = $forPdf
                ? Storage::disk('public')->path($signaturePath)
                : Storage::disk('public')->url($signaturePath);
        }

        return [
            'invoice' => $invoice,
            'student' => $invoice->student,
            'preparedBySignature' => $preparedBySignature,
            'classes' => $classes,
            'totals' => [
                'subtotal' => $subtotal,
                'total' => $total,
                'discount' => max(0, $subtotal - $total),
                'paid' => $paid,
                'balance' => max(0, $total - $paid),
            ],
        ];
    }

    public function generatePdf(Invoice $invoice): string
    {
        $content = Pdf::loadView(
            'invoices.student',
            $this->viewData($invoice, true)
        )->output();

        if (! str_starts_with($content, '%PDF-')) {
            throw new \RuntimeException('Invoice PDF generation returned invalid content.');
        }

        return $content;
    }
}
