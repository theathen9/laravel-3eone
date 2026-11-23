<?php

namespace Tests\Feature;

use App\Http\Middleware\ApiAuth;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class InvoicePdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_pdf_route_returns_pdf_content(): void
    {
        [$invoice, $employeeId] = $this->createInvoice('Paid');
        $paymentMethodId = DB::table('tblPaymentMethods')->insertGetId([
            'method_name' => 'Cash',
        ], 'method_id');
        Payment::create([
            'invoice_id' => $invoice->invoice_id,
            'payment_date' => '2026-11-20',
            'amount' => 100,
            'payment_method_id' => $paymentMethodId,
            'created_by' => $employeeId,
            'status' => 'Completed',
        ]);

        $response = $this
            ->withoutMiddleware(ApiAuth::class)
            ->get('/api/v1/invoices/' . $invoice->invoice_id . '/pdf');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    public function test_invoice_pdf_is_unavailable_without_a_completed_payment(): void
    {
        [$invoice] = $this->createInvoice('Partial');

        $response = $this
            ->withoutMiddleware(ApiAuth::class)
            ->get('/api/v1/invoices/' . $invoice->invoice_id . '/pdf');

        $response->assertStatus(409);
        $response->assertJsonPath(
            'error',
            'Invoice is only available after payment is confirmed.'
        );
    }

    public function test_partially_paid_invoice_can_be_downloaded(): void
    {
        [$invoice, $employeeId] = $this->createInvoice('Partial');
        $paymentMethodId = DB::table('tblPaymentMethods')->insertGetId([
            'method_name' => 'Cash',
        ], 'method_id');
        Payment::create([
            'invoice_id' => $invoice->invoice_id,
            'payment_date' => '2026-11-20',
            'amount' => 25,
            'payment_method_id' => $paymentMethodId,
            'created_by' => $employeeId,
            'status' => 'Completed',
        ]);

        $response = $this
            ->withoutMiddleware(ApiAuth::class)
            ->get('/api/v1/invoices/' . $invoice->invoice_id . '/pdf');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    private function createInvoice(string $status): array
    {
        $employeeId = DB::table('tblEmployees')->insertGetId([
            'first_name_kh' => 'Dara',
            'last_name_kh' => 'Sok',
            'first_name_en' => 'Dara',
            'last_name_en' => 'Sok',
            'gender' => 'Male',
            'dob' => '1990-01-01',
            'birth_addr_village' => 'Village',
            'birth_addr_commune' => 'Commune',
            'birth_addr_district' => 'District',
            'birth_addr_province' => 'Province',
            'curr_addr_village' => 'Village',
            'curr_addr_commune' => 'Commune',
            'curr_addr_district' => 'District',
            'curr_addr_province' => 'Province',
            'phone1' => '012345678',
            'hired_at' => '2020-01-01',
            'status' => 1,
        ], 'employee_id');

        DB::table('tblStudents')->insert([
            'student_id' => 1,
            'student_code' => 'STU-00001',
            'first_name_kh' => 'Srey',
            'last_name_kh' => 'Dara',
            'first_name_en' => 'Srey',
            'last_name_en' => 'Dara',
            'gender' => 'Female',
            'dob' => '2005-01-01',
            'birth_addr_village' => 'Village',
            'birth_addr_commune' => 'Commune',
            'birth_addr_district' => 'District',
            'birth_addr_province' => 'Province',
            'curr_addr_village' => 'Village',
            'curr_addr_commune' => 'Commune',
            'curr_addr_district' => 'District',
            'curr_addr_province' => 'Province',
            'phone1' => '098765432',
            'academic_year' => '2026',
            'guardian1_name' => 'Guardian One',
            'guardian2_name' => 'Guardian Two',
            'guardian1_relationship' => 'Parent',
            'guardian2_relationship' => 'Parent',
            'guardian_curr_addr_village' => 'Village',
            'guardian_curr_addr_commune' => 'Commune',
            'guardian_curr_addr_district' => 'District',
            'guardian_curr_addr_province' => 'Province',
            'status' => 'active',
        ]);

        $invoice = Invoice::create([
            'invoice_no' => 'INV-TEST-1',
            'student_id' => 1,
            'invoice_date' => '2026-11-20',
            'total_amount' => 100,
            'created_by' => $employeeId,
            'status' => $status,
        ]);

        return [$invoice, $employeeId];
    }
}
