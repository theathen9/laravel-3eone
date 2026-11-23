<?php

namespace Tests\Feature;

use App\Models\BranchHistory;
use App\Services\BranchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_returns_database_generated_branch_defaults(): void
    {
        $branch = (new BranchService())->create([
            'branch_code' => 'BR009',
            'branch_name' => 'New Campus',
        ]);

        $this->assertTrue($branch->status);
        $this->assertNotNull($branch->created_at);
        $this->assertDatabaseHas('tblBranchHistory', [
            'branch_id' => $branch->branch_id,
            'action' => 'created',
            'branch_code' => 'BR009',
        ]);
    }

    public function test_it_records_branch_updates_and_deletions(): void
    {
        $service = new BranchService();
        $branch = $service->create([
            'branch_code' => 'BR010',
            'branch_name' => 'Old Name',
        ]);

        $service->update($branch->branch_id, [
            'branch_code' => 'BR011',
            'branch_name' => 'New Name',
        ]);

        $this->assertDatabaseHas('tblBranchHistory', [
            'branch_id' => $branch->branch_id,
            'action' => 'updated',
            'branch_code' => 'BR011',
            'branch_name' => 'New Name',
        ]);

        $service->delete($branch->branch_id);

        $this->assertDatabaseHas('tblBranchHistory', [
            'branch_id' => $branch->branch_id,
            'action' => 'deleted',
            'branch_code' => 'BR011',
        ]);
        $this->assertSame(
            3,
            BranchHistory::where('branch_id', $branch->branch_id)->count()
        );
    }
}
