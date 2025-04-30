<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'employee_id'     => ['nullable', 'exists:employees,id'],
            'client_id'       => ['nullable', 'exists:clients,id'],
            'shop_id'         => ['required', 'exists:shops,id'],
            'discount'        => ['required', 'numeric', 'lte:100'],
            'skus'            => ["required", "array"],
            'skus.*.sku'      => ['required', 'exists:skus,sku'],
            'skus.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
