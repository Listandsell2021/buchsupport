<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = ['male', 'female'];
        $status = [0, 1];

        $userRange = rand(1000000000000000, 9999999999999999);

        return [
            'uid' => $userRange,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'dob' => fake()->date(),
            'gender' => $gender[array_rand($gender)],
            'phone_no' => fake()->phoneNumber(),
            'street' => fake()->streetAddress(),
            'postal_code' => rand(0, 99999),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'note' => '...',
            'image_path' => null,
            'is_special' => 1,
            'secondary_first_name' => fake()->firstName(),
            'secondary_last_name' => fake()->lastName(),
            'is_active' => $status[array_rand($status)],
            'registered_at' => now(),
            'remember_token' => Str::random(10),
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
