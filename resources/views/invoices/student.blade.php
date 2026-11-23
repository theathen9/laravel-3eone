<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Invoice</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 38px 44px 140px;
            color: #1f2937;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header {
            margin: -38px -44px 28px;
            padding: 27px 44px 23px;
            border-bottom: 5px solid #d1935c;
            background: #0f172a;
            color: #ffffff;
        }

        .header td {
            vertical-align: top;
        }

        .brand {
            color: #f0b77f;
            font-size: 23px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .brand-subtitle,
        .invoice-date,
        .invoice-number {
            color: #cbd5e1;
        }

        .invoice-title {
            font-size: 26px;
            font-weight: bold;
            text-align: right;
        }

        .invoice-date,
        .invoice-number {
            margin-top: 5px;
            text-align: right;
        }

        .section-label {
            margin-bottom: 8px;
            color: #64748b;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .metadata {
            margin-bottom: 25px;
        }

        .metadata td {
            width: 50%;
            padding: 0 16px 0 0;
            vertical-align: top;
        }

        .metadata p {
            margin: 3px 0;
            line-height: 1.5;
        }

        .primary-text {
            color: #0f172a;
            font-size: 12px;
            font-weight: bold;
        }

        .muted {
            color: #64748b;
        }

        .items th {
            padding: 10px 8px;
            background: #0f172a;
            color: #ffffff;
            font-size: 8px;
            letter-spacing: .5px;
            text-align: left;
            text-transform: uppercase;
        }

        .items td {
            padding: 11px 8px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .items tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-right {
            text-align: right !important;
        }

        .totals {
            width: 55%;
            margin: 18px 0 0 auto;
        }

        .totals td {
            padding: 5px 8px;
        }

        .totals .divider td {
            padding-top: 9px;
            border-top: 1px solid #cbd5e1;
        }

        .grand-total {
            color: #b87d49;
            font-size: 14px;
            font-weight: bold;
        }

        .payment-status {
            display: inline-block;
            margin-top: 22px;
            padding: 8px 14px;
            border: 2px solid #16a34a;
            border-radius: 5px;
            color: #15803d;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .signature {
            width: 230px;
            margin: 35px auto 0 0;
            text-align: left;
        }

        .signature-label {
            color: #0f172a;
            font-size: 12px;
            font-weight: bold;
        }

        .signature-line {
            height: 28px;
            border-bottom: 1px solid #64748b;
        }

        .signature-image {
            display: block;
            max-width: 180px;
            max-height: 56px;
        }

        .signature-name {
            margin-top: 6px;
            color: #0f172a;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            right: 0;
            bottom: 0;
            left: 0;
            margin: 0;
            padding: 18px 44px;
            border-top: 3px solid #d1935c;
            background: #0f172a;
            color: #cbd5e1;
            line-height: 1.6;
        }

        .footer strong {
            color: #ffffff;
            font-size: 11px;
        }
    </style>
</head>

<body>
    @php
    $studentName = trim(($student?->first_name_en ?? '') . ' ' . ($student?->last_name_en ?? ''));
    $invoiceNumber = $invoice->invoice_no ?: 'INV-' . $invoice->invoice_id;
    $status = strtoupper((string) $invoice->status);
    $latestPayment = $invoice->payments->sortByDesc('payment_id')->first();
    @endphp

    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="brand">3EONE ACADEMY</div>
                    <div class="brand-subtitle">Student registration invoice</div>
                </td>
                <td>
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number">No. {{ $invoiceNumber }}</div>
                    <div class="invoice-date">
                        Issued {{ $invoice->invoice_date?->format('d M Y') ?? now()->format('d M Y') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="metadata">
        <tr>
            <td>
                <div class="section-label">Billed to</div>
                <p class="primary-text">{{ $studentName ?: 'Student' }}</p>
                <p class="muted">Student ID: {{ $student?->student_code ?? $student?->student_id ?? '—' }}</p>
                @if ($student?->email)
                <p class="muted">{{ $student->email }}</p>
                @endif
                @if ($student?->phone1)
                <p class="muted">{{ $student->phone1 }}</p>
                @endif
            </td>
            <td>
                <div class="section-label">Invoice details</div>
                <p><span class="muted">Academic year:</span> {{ $student?->academic_year ?? '—' }}</p>
                <p><span class="muted">Status:</span> {{ ucfirst(strtolower($invoice->status)) }}</p>
                @if ($latestPayment)
                <p><span class="muted">Payment:</span> {{ $latestPayment->paymentMethod?->method_name ?? 'Recorded' }}</p>
                @if ($latestPayment->reference_no)
                <p><span class="muted">Reference:</span> {{ $latestPayment->reference_no }}</p>
                @endif
                @endif
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th>Academic year</th>
                <th class="text-right">Amount (USD)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoice->items as $item)
            @php
            $class = $item->enrollment?->class;
            $description = $class?->course?->course_name
            ? $class->course->course_name
            : ($class?->class_name ?? $item->description ?? 'Class enrollment');
            @endphp
            <tr>
                <td>
                    <strong>{{ $description }}</strong>
                    @if ($class?->class_code)
                    <br><span class="muted">{{ $class->class_code }}</span>
                    @endif
                </td>
                <td>{{ $class?->academic_year ?? $student?->academic_year ?? '—' }}</td>
                <td class="text-right">${{ number_format((float) $item->amount, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="muted">No invoice items.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="muted">Subtotal</td>
            <td class="text-right">${{ number_format($totals['subtotal'], 2) }}</td>
        </tr>
        <tr>
            <td class="muted">Discount</td>
            <td class="text-right">-${{ number_format($totals['discount'], 2) }}</td>
        </tr>
        <tr class="divider">
            <td class="grand-total">Total</td>
            <td class="text-right grand-total">${{ number_format($totals['total'], 2) }}</td>
        </tr>
        <tr>
            <td class="muted">Paid</td>
            <td class="text-right">${{ number_format($totals['paid'], 2) }}</td>
        </tr>
        <tr>
            <td><strong>Balance</strong></td>
            <td class="text-right"><strong>${{ number_format($totals['balance'], 2) }}</strong></td>
        </tr>
    </table>

    @if (in_array($status, ['PAID', 'PARTIAL'], true))
    <div class="payment-status">
        {{ $status === 'PAID' ? 'PAID' : 'PARTIAL PAYMENT RECEIVED' }}
    </div>
    @endif

    @php
    $preparedBy = trim(($invoice->creator?->first_name_en ?? '') . ' ' . ($invoice->creator?->last_name_en ?? ''));
    @endphp
    <div class="signature">
        <div class="signature-label">Prepared by</div>
        @if ($preparedBySignature)
        <img class="signature-image" src="{{ $preparedBySignature }}" alt="Prepared by signature">
        @endif
        <div class="signature-name">{{ $preparedBy ?: '—' }}</div>
        <div class="signature-line"></div>
    </div>

    <div class="footer">
        <strong>Thank you for choosing 3EONE Academy.</strong><br>
        This is a computer-generated invoice for student registration.
    </div>
</body>

</html>