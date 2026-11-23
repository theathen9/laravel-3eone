<?php

namespace Tests\Feature;

use App\Services\PositionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_returns_position_defaults_and_generated_time(): void
    {
        $position = (new PositionService())->create([
            'position_code' => 'POS001',
            'position_name' => 'Teacher',
        ]);

        $this->assertSame(1, $position->status);
        $this->assertNotNull($position->created_at);
    }
}
