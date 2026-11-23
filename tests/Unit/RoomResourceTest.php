<?php

namespace Tests\Unit;

use App\Http\Resources\Api\V1\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class RoomResourceTest extends TestCase
{
    public function test_it_serializes_room_details(): void
    {
        $room = new Room();
        $room->setRawAttributes([
            'room_id' => 4,
            'room_name' => 'Room A101',
            'capacity' => 30,
            'status' => 1,
        ]);

        $this->assertSame([
            'room_id' => 4,
            'room_name' => 'Room A101',
            'capacity' => 30,
            'status' => 1,
        ], (new RoomResource($room))->resolve(Request::create('/')));
    }
}
