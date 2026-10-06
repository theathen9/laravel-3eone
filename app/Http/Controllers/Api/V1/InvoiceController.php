<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function pdf(Request $request, Invoice $invoice)
    {
        abort_unless($invoice->exists, 404);

        $invoice->load([
            'student',
            'items.enrollment.class.course',
            'items.enrollment.class.teacher',
            'items.enrollment.class.room',
            'items.enrollment.class.timeSlot',
            'items.enrollment.class.timetables.day',
        ]);

        $classes = $invoice->items
            ->map(fn($item) => $item->enrollment?->class)
            ->filter();

        $pdf = Pdf::loadView('invoices.student', [
            'invoice' => $invoice,
            'student' => $invoice->student,
            'classes' => $classes,
        ]);

        return $pdf->download(
            'invoice-' . $invoice->invoice_no . '.pdf'
        );
    }
    public function previewInvoice(Request $request, Invoice $invoice)
    {
        abort_unless($invoice->exists, 404);

        $invoice->load([
            'student',
            'items.enrollment',
        ]);

        $classes = $invoice->items
            ->map(fn($item) => $item->enrollment?->class)
            ->filter();

        return view('invoices.student', [
            'invoice' => $invoice,
            'student' => $invoice->student,
            'classes' => $classes,
        ]);
    }
}
