<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    /**
     * Create a new policy instance.
     */
    public function view(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    public function update(User $user, Client $client): bool
    {
        return $this->owns($user, $client);
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    private function owns(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }
}
