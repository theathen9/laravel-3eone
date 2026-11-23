<?php

namespace Tests\Feature;

use App\Services\RoomService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_returns_the_database_default_room_status(): void
    {
        $room = (new RoomService())->create([
            'room_name' => 'Room A101',
            'capacity' => 30,
        ]);

        $this->assertSame(1, $room->status);
    }
}
