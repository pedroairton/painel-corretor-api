<?php

namespace App\Http\Requests\Contact;

use App\Enums\ContactResult;
use App\Enums\ContactType;
use App\Enums\InterestStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
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
                'required',
                Rule::enum(ContactType::class)
            ],
            'contact_date' => ['required', 'date', 'before:tomorrow'],
            'result' => ['required', Rule::enum(ContactResult::class)],
            'feedback' => ['required', 'string'],
            'interest_status_after' => ['required', Rule::enum(InterestStatus::class)],
        ];
    }
}
