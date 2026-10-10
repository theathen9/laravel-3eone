<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $gender = fake()->randomElement([
            'Male',
            'Female',
        ]);

        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            'department_id' => Department::query()
                ->inRandomOrder()
                ->value('department_id'),

            'position_id' => Position::query()
                ->inRandomOrder()
                ->value('position_id'),

            'first_name_kh' => $firstName,
            'last_name_kh' => $lastName,

            'first_name_en' => $firstName,
            'last_name_en' => $lastName,

            'gender' => $gender,

            'dob' => fake()->dateTimeBetween(
                '-60 years',
                '-22 years'
            ),

            'birth_addr_village' => fake()->streetName(),
            'birth_addr_commune' => fake()->city(),
            'birth_addr_district' => fake()->city(),
            'birth_addr_province' => fake()->state(),

            'curr_addr_village' => fake()->streetName(),
            'curr_addr_commune' => fake()->city(),
            'curr_addr_district' => fake()->city(),
            'curr_addr_province' => fake()->state(),

            'phone1' => fake()->unique()->numerify('0########'),
            'phone2' => fake()->optional()->numerify('0########'),

            'email' => fake()->unique()->safeEmail(),

            'profile_image' => null,

            'hired_at' => fake()->dateTimeBetween(
                '-10 years',
                'now'
            ),

            'status' => 1,
        ];
    }
}
