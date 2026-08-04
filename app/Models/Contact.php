<?php

namespace App\Models;

use App\Enums\ContactResult;
use App\Enums\ContactType;
use App\Enums\InterestStatus;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'client_id',
        'contact_type',
        'contact_date',
        'result',
        'feedback',
        'interest_status_after',
    ];

    protected $casts = [
        'contact_date' => 'datetime',
        'contact_type' => ContactType::class,
        'result' => ContactResult::class,
        'interest_status_after' => InterestStatus::class,
        'last_contact_at' => 'datetime',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function isLatest(){
        return $this->client->latestContact()->value('id') === $this->id;
    }
}
