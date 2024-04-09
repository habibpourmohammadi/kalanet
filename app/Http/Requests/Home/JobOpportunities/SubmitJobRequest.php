<?php

namespace App\Http\Requests\Home\JobOpportunities;

use Illuminate\Foundation\Http\FormRequest;

class SubmitJobRequest extends FormRequest
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
            "description" => ["nullable"],
            "file_path" => ["required", "file", "mimes:png,jpg,jpeg,pdf", "max:2000"],
        ];
    }

    public function attributes()
    {
        return [
            "file_path" => "رزومه"
        ];
    }
}
