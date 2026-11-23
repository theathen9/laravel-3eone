<?php

namespace Tests\Unit;

use App\Http\Resources\Api\V1\PositionResource;
use App\Models\Position;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class PositionResourceTest extends TestCase
{
    public function test_it_serializes_position_fields(): void
    {
        $position = new Position();
        $position->setRawAttributes([
            'position_id' => 3,
            'position_code' => 'POS003',
            'position_name' => 'Teacher',
            'description' => 'Instructional staff',
            'status' => 1,
            'created_at' => null,
        ]);

        $data = (new PositionResource($position))->resolve(Request::create('/'));

        $this->assertSame(3, $data['position_id']);
        $this->assertSame('POS003', $data['position_code']);
        $this->assertSame('Teacher', $data['position_name']);
        $this->assertSame('Instructional staff', $data['description']);
        $this->assertSame(1, $data['status']);
    }
}
