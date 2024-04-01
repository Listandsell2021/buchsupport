<?php

namespace Database\Factories;

use App\DataHolders\Enum\AuthRole;
use App\DataHolders\Enum\Gender;
use App\Models\Admin;
use App\Models\SalesPerson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = Gender::onlyNames();
        $status = [0, 1];

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'), //
            'gender' => $gender[array_rand($gender)],
            'street' => fake()->streetAddress(),
            'dob' => '2000-01-01',
            'phone_no' => fake()->phoneNumber(),
            'postal_code' => rand(0, 99999),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'auth_role' => AuthRole::getAdminRole(),
            'role_id' => null,
            'is_active' => 1,
        ];

    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
