<?php

namespace App\Http\Requests\Contact;

use App\Enums\ContactResult;
use App\Enums\ContactType;
use App\Enums\InterestStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_type' => [
                'sometimes',
                Rule::enum(ContactType::class)
            ],
            'contact_date' => ['sometimes', 'date'],
            'result' => ['sometimes', Rule::enum(ContactResult::class)],
            'feedback' => ['sometimes', 'string'],
            'interest_status_after' => ['sometimes', Rule::enum(InterestStatus::class)],
        ];
    }
}
