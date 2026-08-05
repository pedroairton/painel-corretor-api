<?php

namespace Database\Seeders;

use App\Enums\ContactResult;
use App\Enums\ContactType;
use App\Enums\InterestStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@teste.com',
        ]);

        $clients = [

            [

                'name' => 'João Silva',

                'phone' => '(81)99999-1111',

                'interest_status' => InterestStatus::VERY_INTERESTED,

                'priority' => 5,

            ],

            [

                'name' => 'Maria Oliveira',

                'phone' => '(81)99999-2222',

                'interest_status' => InterestStatus::MODERATED_INTEREST,

                'priority' => 4,

            ],

            [

                'name' => 'Carlos Souza',

                'phone' => '(81)99999-3333',

                'interest_status' => InterestStatus::CLOSED_DEAL,

                'priority' => 5,

            ],

        ];

        foreach ($clients as $clientData) {

            $client = $user->clients()->create([

                ...$clientData,

                'email' => fake()->safeEmail(),

                'income' => fake()->numberBetween(3000, 12000),

                'birth_date' => fake()->date(),

                'needs' => fake()->sentence(),

                'has_property' => fake()->boolean(),

                'marital_status' => 'married',

                'has_children' => fake()->boolean(),

                'notes' => fake()->paragraph(),

            ]);

            for ($i = 1; $i <= 3; $i++) {

                $contact = $client->contacts()->create([

                    'contact_type' => ContactType::CALL,

                    'contact_date' => Carbon::now()->subDays(4 - $i),

                    'result' => ContactResult::ANSWERED,

                    'feedback' => "Contato {$i} realizado com sucesso.",

                    'interest_status_after' => $client->interest_status,

                ]);
            }

            $client->syncFromLatestContact();
        }
    }
}
