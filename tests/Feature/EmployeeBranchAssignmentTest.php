<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\EmployeeBranchHistory;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\BranchService;
use App\Services\EmployeeService;
use Tests\TestCase;

class EmployeeBranchAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_requires_and_stores_a_branch(): void
    {
        $this->withoutMiddleware();

        $branch = Branch::create([
            'branch_code' => 'MAIN',
            'branch_name' => 'Main Branch',
        ]);
        $payload = $this->employeePayload();

        $this->postJson('/api/v1/employees', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('branch_id');

        $this->postJson('/api/v1/employees', $payload + [
            'branch_id' => $branch->branch_id,
        ])
            ->assertCreated()
            ->assertJsonPath('data.branch_id', $branch->branch_id)
            ->assertJsonPath('data.employee_code', 'MAIN-0001');

        $this->getJson('/api/v1/employees/1001')
            ->assertOk()
            ->assertJsonPath('data.employee_code', 'MAIN-0001')
            ->assertJsonPath('data.branch.branch_code', 'MAIN')
            ->assertJsonPath('data.branch_histories.0.branch_code', 'MAIN');

        $this->assertDatabaseHas('tblEmployeeBranchHistory', [
            'employee_id' => 1001,
            'branch_id' => $branch->branch_id,
            'branch_code' => 'MAIN',
            'end_date' => null,
        ]);
        $this->assertSame(
            '2020-01-01',
            EmployeeBranchHistory::where('employee_id', 1001)
                ->sole()
                ->start_date
                ->toDateString()
        );
    }

    public function test_employee_branch_changes_are_kept_in_history(): void
    {
        $firstBranch = Branch::create([
            'branch_code' => 'BR001',
            'branch_name' => 'First Branch',
        ]);
        $nextBranch = Branch::create([
            'branch_code' => 'BR002',
            'branch_name' => 'Second Branch',
        ]);
        $employee = (new EmployeeService())->create(
            $this->employeePayload() + ['branch_id' => $firstBranch->branch_id]
        );

        (new EmployeeService())->update($employee->employee_id, [
            'branch_id' => $nextBranch->branch_id,
        ]);

        $history = EmployeeBranchHistory::where(
            'employee_id',
            $employee->employee_id
        )->orderBy('start_date')->get();

        $this->assertCount(2, $history);
        $this->assertSame('BR001', $history[0]->branch_code);
        $this->assertSame(
            now()->subDay()->toDateString(),
            $history[0]->end_date->toDateString()
        );
        $this->assertSame('BR002', $history[1]->branch_code);
        $this->assertSame(now()->toDateString(), $history[1]->start_date->toDateString());
        $this->assertNull($history[1]->end_date);
        $this->assertSame('BR001-0001', $employee->fresh()->employee_code);
    }

    public function test_branch_employee_codes_are_sequential_per_branch(): void
    {
        $firstBranch = Branch::create([
            'branch_code' => 'BR001',
            'branch_name' => 'First Branch',
        ]);
        $secondBranch = Branch::create([
            'branch_code' => 'BR002',
            'branch_name' => 'Second Branch',
        ]);
        $service = new EmployeeService();

        $existingEmployee = $service->create($this->employeePayload());
        $firstBranchEmployee = $service->update(
            $existingEmployee->employee_id,
            ['branch_id' => $firstBranch->branch_id]
        );
        $secondBranchEmployee = $service->create(
            array_replace($this->employeePayload(), ['employee_id' => 1002])
                + ['branch_id' => $firstBranch->branch_id]
        );
        $otherBranchEmployee = $service->create(
            array_replace($this->employeePayload(), ['employee_id' => 1003])
                + ['branch_id' => $secondBranch->branch_id]
        );

        $this->assertSame('BR001-0001', $firstBranchEmployee->employee_code);
        $this->assertSame('BR001-0002', $secondBranchEmployee->employee_code);
        $this->assertSame('BR002-0001', $otherBranchEmployee->employee_code);
    }

    public function test_teacher_directory_searches_by_branch_code_and_numeric_id(): void
    {
        $this->withoutMiddleware();

        $branch = Branch::create([
            'branch_code' => 'BR001',
            'branch_name' => 'First Branch',
        ]);
        $position = Position::create([
            'position_code' => 'TCH',
            'position_name' => 'Teacher',
        ]);
        (new EmployeeService())->create(
            $this->employeePayload() + [
                'branch_id' => $branch->branch_id,
                'position_id' => $position->position_id,
            ]
        );

        $this->get('/admin/people/teachers?search=BR001-0001')
            ->assertOk()
            ->assertSee('Branch Employee ID')
            ->assertSee('BR001-0001')
            ->assertSee('1001')
            ->assertSee('View teacher')
            ->assertSee('Edit teacher')
            ->assertSee('Delete teacher')
            ->assertSee('employeeDetailDialog')
            ->assertSee('employeeEditDialog');

        $this->get('/admin/people/teachers?search=1001')
            ->assertOk()
            ->assertSee('BR001-0001');
    }

    public function test_deleting_a_branch_closes_employee_assignment_history(): void
    {
        $branch = Branch::create([
            'branch_code' => 'BR001',
            'branch_name' => 'First Branch',
        ]);
        $employee = (new EmployeeService())->create(
            $this->employeePayload() + ['branch_id' => $branch->branch_id]
        );

        (new BranchService())->delete($branch->branch_id);

        $history = EmployeeBranchHistory::where(
            'employee_id',
            $employee->employee_id
        )->sole();

        $this->assertNull($employee->fresh()->branch_id);
        $this->assertSame(
            now()->subDay()->toDateString(),
            $history->end_date->toDateString()
        );
    }

    private function employeePayload(): array
    {
        return [
            'employee_id' => 1001,
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
        ];
    }
}
