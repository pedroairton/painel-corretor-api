<?php

namespace Database\Factories;

use App\Enums\ContactResult;
use App\Enums\ContactType;
use App\Enums\InterestStatus;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_type' => fake()->randomElement(ContactType::values()),
            'contact_date' => fake()->dateTimeBetween('-30 days'),
            'result' => fake()->randomElement(ContactResult::values()),
            'feedback' => fake()->paragraph(),
            'interest_status_after' => fake()->randomElement(InterestStatus::values())
        ];
    }
}
