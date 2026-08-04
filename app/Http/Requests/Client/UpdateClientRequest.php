<?php

namespace App\Http\Requests\Client;

use App\Enums\InterestStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:20'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'income' => ['nullable', 'numeric', 'min:0'],
            'birth_date' => ['nullable', 'date'],
            'needs' => ['nullable', 'string'],
            'has_property' => ['nullable', 'boolean'],
            'marital_status' => ['nullable', 'string', 'in:single,married,divorced,widowed,stable_union'],
            'has_children' => ['sometimes', 'boolean'],
            'notes' => ['nullable', 'string'],
            'interest_status' => ['sometimes', Rule::enum(InterestStatus::class)],
            'priority' > [
                'nullable',
                'integer',
                'between:1,5',
            ]
        ];
    }
}
