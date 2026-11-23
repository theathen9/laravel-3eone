<?php

namespace Tests\Feature;

use App\Models\EmployeePositionHistory;
use App\Models\Branch;
use App\Models\Position;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeePositionHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_initial_position_and_closes_it_when_the_position_changes(): void
    {
        $branch = Branch::create([
            'branch_code' => 'MAIN',
            'branch_name' => 'Main Branch',
        ]);
        $firstPosition = Position::create([
            'position_code' => 'TEACHER',
            'position_name' => 'Teacher',
        ]);
        $nextPosition = Position::create([
            'position_code' => 'DIRECTOR',
            'position_name' => 'Director',
        ]);

        $service = new EmployeeService();
        $employee = $service->create([
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
            'branch_id' => $branch->branch_id,
            'position_id' => $firstPosition->position_id,
        ]);

        $this->assertSame($branch->branch_code, $employee->branch->branch_code);

        $initialHistory = EmployeePositionHistory::where(
            'employee_id',
            $employee->employee_id
        )->sole();
        $this->assertSame(
            $firstPosition->position_id,
            $initialHistory->position_id
        );
        $this->assertSame('2020-01-01', $initialHistory->start_date->toDateString());
        $this->assertSame('2020-01-01', $initialHistory->toArray()['start_date']);
        $this->assertNull($initialHistory->end_date);

        $service->update($employee->employee_id, [
            'position_id' => $nextPosition->position_id,
        ]);
        $service->update($employee->employee_id, [
            'phone2' => '098765432',
        ]);

        $history = EmployeePositionHistory::where(
            'employee_id',
            $employee->employee_id
        )->orderBy('start_date')->get();

        $this->assertCount(2, $history);
        $this->assertSame(
            now()->subDay()->toDateString(),
            $history[0]->end_date->toDateString()
        );
        $this->assertSame(
            $nextPosition->position_id,
            $history[1]->position_id
        );
        $this->assertSame(now()->toDateString(), $history[1]->start_date->toDateString());
        $this->assertNull($history[1]->end_date);
    }
}
