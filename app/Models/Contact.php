<?php

namespace App\Models;

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
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
