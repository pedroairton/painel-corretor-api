<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'income' => $this->income,
            'birth_date' => $this->birth_date,
            'needs' => $this->needs,
            'has_property' => $this->has_property,
            'marital_status' => $this->marital_status,
            'has_children' => $this->has_children,
            'notes' => $this->notes,
            'interest_status' => [
                'value' => $this->interest_status->value,
                'label' => $this->interest_status->label(),
            ],
            'priority' => $this->priority,
            'contacts_count' => $this->contacts_count,
            'latest_contact' => new ContactResource(
                $this->whenLoaded('latestContact')
            ),
            'contacts' => ContactResource::collection(
                $this->whenLoaded('contacts')
            ),
            'created_at' => $this->created_at
        ];
    }
}
