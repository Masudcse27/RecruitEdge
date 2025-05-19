<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string',
            'salary' => 'nullable|integer|min:0',
            'deadline' => 'required|date|after_or_equal:today',
        ];
    }
}
