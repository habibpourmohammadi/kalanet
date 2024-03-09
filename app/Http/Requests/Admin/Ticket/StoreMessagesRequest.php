<?php

namespace App\Http\Requests\Admin\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessagesRequest extends FormRequest
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
            "message" => ["required", "string"],
            "file_path" => ["nullable", "mimes:png,jpg,jpeg,xlsx,xls,docx,doc,pdf", "max:1024"],
        ];
    }


    public function attributes()
    {
        return [
            "message" => "پیام",
            "file_path" => "فایل ضمیمه",
        ];
    }
}
