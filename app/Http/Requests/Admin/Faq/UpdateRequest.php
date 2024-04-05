<?php

namespace App\Http\Requests\Admin\Faq;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "question" => ["required", "unique:faq_items,question," . $this->faq->id, "max:255"],
            "answer" => ["required"],
        ];
    }

    public function attributes()
    {
        return [
            "question" => "سوال",
            "answer" => "پاسخ",
        ];
    }
}
