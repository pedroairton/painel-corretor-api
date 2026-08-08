<?php

namespace App\Http\Requests\Client;

use App\Enums\InterestStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
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
        // dd($this->all());
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'income' => ['nullable', 'numeric', 'min:0'],
            'birth_date' => ['nullable', 'date'],
            'needs' => ['nullable', 'string'],
            'has_property' => ['nullable', 'boolean'],
            'marital_status' => ['nullable', 'string', 'in:single,married,divorced,widowed,stable_union'],
            'has_children' => ['required', 'boolean'],
            'notes' => ['nullable', 'string'],
            'interest_status' => ['required', Rule::enum(InterestStatus::class)],
            'priority' => [
                'nullable',
                'integer',
                'between:1,5',
            ]
        ];
    }
}
