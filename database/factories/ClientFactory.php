<?php

namespace Database\Factories;

use App\Enums\InterestStatus;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->cellphoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'income' => fake()->numberBetween(1000, 15000),
            'birth_date' => fake()->date(),
            'needs' => fake()->sentence(),
            'has_property' => fake()->boolean(),
            'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed', 'stable_union']),
            'has_children' => fake()->boolean(),
            'notes' => fake()->paragraph(),
            'interest_status' => fake()->randomElement(InterestStatus::values()),
            'priority' => fake()->numberBetween(1, 5),
        ];
    }
}
