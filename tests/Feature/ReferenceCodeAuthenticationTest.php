<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferenceCodeAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_and_student_reference_codes_can_be_used_to_sign_in(): void
    {
        $role = Role::create([
            'role_name' => 'Member',
        ]);
        $accounts = [
            [
                'reference_id' => 101,
                'reference_type' => 'Employee',
                'reference_code' => 'BR001-0001',
                'username' => 'employee-user',
                'email' => 'employee@example.test',
            ],
            [
                'reference_id' => 202,
                'reference_type' => 'Student',
                'reference_code' => 'STU-2026-001',
                'username' => 'student-user',
                'email' => 'student@example.test',
            ],
        ];
        $authService = app(AuthService::class);

        foreach ($accounts as $account) {
            $user = User::create($account + [
                'password' => 'correct-password',
                'role_id' => $role->role_id,
                'status' => 1,
            ]);

            $authenticatedUser = $authService->authenticate(
                $account['reference_code'],
                'correct-password'
            );

            $this->assertNotNull($authenticatedUser);
            $this->assertSame($user->user_id, $authenticatedUser->user_id);
            $this->assertNotNull($authenticatedUser->fresh()->last_login);
        }
    }
}
