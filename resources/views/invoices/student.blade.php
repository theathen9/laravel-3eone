<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Student Invoice</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        .invoice {
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 3px 0;
        }

        .invoice-info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="invoice">

        <div class="header">
            <h1>3E ONE Academy</h1>
            <p>Student Registration Invoice</p>
            <p>Invoice #{{ $invoice->invoice_id }}</p>
        </div>

        <div class="invoice-info">
            <strong>Student:</strong>
            {{ $student->first_name_en ?? '' }}
            {{ $student->last_name_en ?? '' }}
            <br>

            <strong>Student ID:</strong>
            {{ $student->student_id ?? '' }}
            <br>

            <strong>Date:</strong>
            {{ $invoice->created_at?->format('Y-m-d') ?? now()->format('Y-m-d') }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Course</th>
                    <th>Study</th>
                    <th>Time</th>
                    <th class="text-right">Price</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($invoice->items as $item)
                @php
                $class = $item->enrollment?->class;
                @endphp

                <tr>
                    <td>{{ $class?->class_code ?? '-' }}</td>

                    <td>
                        {{ $class?->course?->course_name ?? '-' }}
                    </td>

                    <td>
                        {{-- Study --}}
                        -
                    </td>

                    <td>
                        {{-- Time --}}
                        -
                    </td>

                    <td>
                        ${{ number_format((float) $item->amount, 2) }}
                    </td>
                </tr>
                @endforeach

            </tbody>

            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">
                        Total
                    </td>

                    <td class="text-right total">
                        ${{ number_format($invoice->total ?? 0, 2) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="text-right">
                        Discount
                    </td>

                    <td class="text-right">
                        ${{ number_format($invoice->discount ?? 0, 2) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="text-right">
                        Paid
                    </td>

                    <td class="text-right">
                        ${{ number_format($invoice->paid ?? 0, 2) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="text-right">
                        Balance
                    </td>

                    <td class="text-right total">
                        ${{ number_format($invoice->balance ?? 0, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>

</body>

</html>