<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'firstname'  => ['required', 'max:50'],
            'lastname'   => ['required', 'max:50'],
            'zipcode'    => ['required', 'max:12'],
            'email'      => ['required', 'email', 'max:320'],
            'phone'      => ['required', "max:22"],
            'newsletter' => ['required', "boolean"],
            'birthdate'  => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
