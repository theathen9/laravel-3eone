<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;


class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceService $invoiceService
    ) {}

    public function pdf(Invoice $invoice): Response
    {
        if (! $this->invoiceService->isInvoiceable($invoice)) {
            return response()->json([
                'error' => 'Invoice is only available after payment is confirmed.',
            ], 409);
        }

        $content = $this->invoiceService->generatePdf($invoice);

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => sprintf(
                'attachment; filename="invoice-%d.pdf"',
                $invoice->invoice_id
            ),
            'Content-Length' => (string) strlen($content),
            'Cache-Control' => 'no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function previewInvoice(Invoice $invoice): View
    {
        return view(
            'invoices.student',
            $this->invoiceService->viewData($invoice)
        );
    }
}
