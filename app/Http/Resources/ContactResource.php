<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'contact_type' => [
                'value' => $this->contact_type->value,
                'label' => $this->contact_type->label(),
            ],
            'contact_date' => $this->contact_date,
            'result' => [
                'value' => $this->result->value,
                'label' => $this->result->label(),
            ],
            'feedback' => $this->feedback,
            'interest_status_after' => [
                'value' => $this->interest_status_after->value,
                'label' => $this->interest_status_after->label(),
            ]
        ];
    }
}
