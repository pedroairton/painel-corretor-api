<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'income',
        'birth_date',
        'needs',
        'has_property',
        'marital_status',
        'has_children',
        'notes',
        'interest_status',
        'priority',
        'last_contact_at',
        'next_contact_at',
        'is_archived',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'has_property' => 'boolean',
        'has_children' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function contacts(){
        return $this->hasMany(Contact::class)->latest('contact_date');
    }
}
