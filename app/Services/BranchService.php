<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\BranchHistory;
use App\Models\EmployeeBranchHistory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BranchService
{
    /**
     * Get paginated branches.
     */
    public function index(int $limit = 10): LengthAwarePaginator
    {
        return Branch::query()
            ->orderByDesc('branch_id')
            ->paginate($limit);
    }

    /**
     * Get paginated branches.
     */
    public function paginate(int $limit = 10): LengthAwarePaginator
    {
        return $this->index($limit);
    }

    /**
     * Create a new Branch.
     */
    public function create(array $data): Branch
    {
        return DB::transaction(function () use ($data) {
            $branch = Branch::create($data)->refresh();
            $this->recordHistory($branch, 'created');

            return $branch;
        });
    }

    /**
     * Find a Branch by ID.
     */
    public function find(int $id): Branch
    {
        return Branch::with('histories')->findOrFail($id);
    }

    /**
     * Update an existing Branch.
     */
    public function update(int $id, array $data): Branch
    {
        return DB::transaction(function () use ($id, $data) {
            $branch = Branch::query()
                ->lockForUpdate()
                ->findOrFail($id);
            $branch->fill($data);

            if ($branch->isDirty()) {
                $branch->save();
                $this->recordHistory($branch, 'updated');
            }

            return $branch->refresh();
        });
    }

    /**
     * Delete a Branch.
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $branch = Branch::query()
                ->lockForUpdate()
                ->findOrFail($id);
            $this->recordHistory($branch, 'deleted');
            $this->closeEmployeeAssignments($branch);

            return (bool) $branch->delete();
        });
    }

    private function recordHistory(Branch $branch, string $action): void
    {
        BranchHistory::create([
            'branch_id' => $branch->branch_id,
            'action' => $action,
            'branch_code' => $branch->branch_code,
            'branch_name' => $branch->branch_name,
            'phones' => $branch->phones,
            'email' => $branch->email,
            'address' => $branch->address,
            'location' => $branch->location,
            'status' => (int) $branch->status,
            'recorded_at' => now(),
        ]);
    }

    private function closeEmployeeAssignments(Branch $branch): void
    {
        $effectiveDate = Carbon::today();
        $histories = EmployeeBranchHistory::query()
            ->where('branch_id', $branch->branch_id)
            ->whereNull('end_date')
            ->get();

        foreach ($histories as $history) {
            $historyStartDate = $history->start_date;
            $history->end_date = $historyStartDate->lessThan($effectiveDate)
                ? $effectiveDate->copy()->subDay()->toDateString()
                : $historyStartDate->toDateString();
            $history->save();
        }
    }
}
