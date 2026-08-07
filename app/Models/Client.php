<?php

namespace App\Models;

use App\Enums\ClientSort;
use App\Enums\InterestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

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
        'interest_status' => InterestStatus::class,
        'is_archived' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class)->latest('contact_date');
    }

    public function latestContact()
    {
        return $this->hasOne(Contact::class)->latestOfMany('contact_date');
    }

    public function syncFromLatestContact()
    {
        $lastContact = $this->latestContact->first();

        if (!$lastContact) {
            $this->update([
                'last_contact_at' => null,
                'interest_status' => InterestStatus::MODERATED_INTEREST,
            ]);

            return;
        }

        $this->update([
            'last_contact_at' => $lastContact->contact_date,
            'interest_status' => $lastContact->interest_status_after
        ]);
    }

    public function scopeFromUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) {
            return;
        }
        $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    public function scopeStatus($query, ?string $status)
    {
        if (!$status) {
            return;
        }
        $query->where('interest_status', $status);
    }

    public function scopeFilters($query, array $filters)
    {
        if (!empty($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('interest_status', $filters['status']);
        }

        match ($filters['sort'] ?? ClientSort::RECENT->value) {

            ClientSort::NAME->value =>
            $query->orderBy('name'),

            ClientSort::PRIORITY->value =>
            $query->orderByDesc('priority'),

            ClientSort::INTEREST->value =>
            $query->orderByRaw("
                CASE interest_status
                    WHEN 'very_interested' THEN 1
                    WHEN 'moderate_interest' THEN 2
                    WHEN 'low_interest' THEN 3
                    WHEN 'no_interest' THEN 4
                    WHEN 'closed_deal' THEN 5
                    ELSE 6
                END
            "),

            default =>
            $query->latest(),
        };

        return $query;
    }
}
