<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'employee_id'     => ['nullable', 'exists:employees,id'],
            'payment_method'  => ['nullable', Rule::enum( PaymentMethodEnum::class )],
            'client_id'       => ['nullable', 'exists:clients,id'],
            'shop_id'         => ['nullable', 'exists:shops,id'],
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
