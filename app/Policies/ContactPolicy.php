<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, Contact $contact): bool{
        return $contact->client->user_id === $user->id;
    }
    public function delete(User $user, Contact $contact): bool{
        return $contact->client->user_id === $user->id;
    }
}
