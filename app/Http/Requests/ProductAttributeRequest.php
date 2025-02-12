<?php

namespace App\Http\Requests;

use App\Enums\ProductTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductAttributeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id'   => ['required', 'exists:products'],
            'name'         => ['required'],
            'product_type' => ['required', Rule::enum( ProductTypeEnum::class )],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
