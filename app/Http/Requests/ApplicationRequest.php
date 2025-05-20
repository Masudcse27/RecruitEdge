<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'job_post_id' => 'required|exists:job_posts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:applications,email',
            'contact_number' => 'required|string|max:20',
            'latest_degree' => 'required|string|max:255',
            'institute' => 'required|string|max:255',
            'cgpa' => 'required|numeric|between:0,4.0',
            'expected_salary' => 'nullable|integer|min:0',
            'github_profile' => 'nullable|url|max:255',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ];

    }
}
