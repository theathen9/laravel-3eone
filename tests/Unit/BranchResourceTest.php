<?php

namespace Tests\Unit;

use App\Http\Resources\Api\V1\BranchResource;
use App\Models\Branch;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class BranchResourceTest extends TestCase
{
    public function test_it_serializes_branch_phones_as_labeled_phones(): void
    {
        $branch = new Branch();
        $branch->setRawAttributes([
            'branch_id' => 7,
            'branch_code' => 'BR007',
            'branch_name' => 'Old Campus',
            'phones' => json_encode([
                ['number' => '063 700 123', 'label' => 'Main'],
                ['number' => '063 700 456', 'label' => 'Alternate'],
            ]),
            'email' => 'branch@example.com',
            'address' => 'Siem Reap, Cambodia',
            'location' => 'Siem Reap',
            'status' => 1,
            'created_at' => null,
        ]);

        $data = (new BranchResource($branch))->resolve(Request::create('/'));

        $this->assertSame([
            ['number' => '063 700 123', 'label' => 'Main'],
            ['number' => '063 700 456', 'label' => 'Alternate'],
        ], $data['phones']);
    }

    public function test_it_serializes_a_single_phone(): void
    {
        $branch = new Branch();
        $branch->setRawAttributes([
            'phones' => json_encode([
                ['number' => '063 700 123', 'label' => 'Main'],
            ]),
        ]);

        $data = (new BranchResource($branch))->resolve(Request::create('/'));

        $this->assertSame([
            ['number' => '063 700 123', 'label' => 'Main'],
        ], $data['phones']);
    }

    public function test_it_returns_an_empty_list_when_branch_has_no_phones(): void
    {
        $branch = new Branch();
        $branch->setRawAttributes(['phones' => null]);

        $data = (new BranchResource($branch))->resolve(Request::create('/'));

        $this->assertSame([], $data['phones']);
    }
}
