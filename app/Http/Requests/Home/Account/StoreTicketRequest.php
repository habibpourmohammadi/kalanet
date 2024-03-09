<?php

namespace App\Http\Requests\Home\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            "title" => ["required", "string", "max:254"],
            "priority_status" => ["required"]
        ];
    }

    public function attributes()
    {
        return [
            "title" => "عنوان",
            "priority_status" => "اولویت",
        ];
    }
}
