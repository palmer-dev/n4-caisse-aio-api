<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'firstname' => ['required'],
            'lastname'  => ['required'],
            'email'     => ['nullable', 'email', 'max:254'],
            'phone'     => ['nullable'],
            'code'      => ['required', 'regex:[0-9]{5}'],
            'shop_id'   => ['required', 'exists:shops'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
