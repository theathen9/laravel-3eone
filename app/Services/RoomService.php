<?php

namespace App\Services;

use App\Models\ClassModel;
use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoomService
{
    public function index(int $limit = 10): LengthAwarePaginator
    {
        return Room::query()
            ->orderBy('room_name')
            ->paginate($limit);
    }

    public function create(array $data): Room
    {
        return Room::query()->create($data)->refresh();
    }

    public function find(int $id): Room
    {
        return Room::query()->findOrFail($id);
    }

    public function update(int $id, array $data): Room
    {
        $room = $this->find($id);
        $room->update($data);

        return $room->refresh();
    }

    public function isAssigned(int $id): bool
    {
        return ClassModel::query()
            ->where('room_id', $id)
            ->exists();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->find($id)->delete();
    }
}
