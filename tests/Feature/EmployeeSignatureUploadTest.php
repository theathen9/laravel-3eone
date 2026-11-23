<?php

namespace Tests\Feature;

use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EmployeeSignatureUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_the_employee_signature_separately_from_the_profile_photo(): void
    {
        Storage::fake('public');

        $employee = (new EmployeeService())->create([
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
            'signature_image' => UploadedFile::fake()->create(
                'signature.png',
                10,
                'image/png'
            ),
        ]);

        $this->assertStringStartsWith('employee-signatures/', $employee->signature_image);
        Storage::disk('public')->assertExists($employee->signature_image);
        $this->assertNull($employee->profile_image);
    }
}
