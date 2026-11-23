<?php

namespace App\Services;

use App\Models\EmployeePositionHistory;
use App\Models\Position;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PositionService
{
    public function index(int $limit = 10): LengthAwarePaginator
    {
        return Position::query()
            ->orderBy('position_name')
            ->paginate($limit);
    }

    public function create(array $data): Position
    {
        $data['created_at'] = now();

        return Position::query()->create($data)->refresh();
    }

    public function find(int $id): Position
    {
        return Position::query()->findOrFail($id);
    }

    public function update(int $id, array $data): Position
    {
        $position = $this->find($id);
        $position->update($data);

        return $position->refresh();
    }

    public function hasHistory(int $id): bool
    {
        return EmployeePositionHistory::query()
            ->where('position_id', $id)
            ->exists();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->find($id)->delete();
    }
}
