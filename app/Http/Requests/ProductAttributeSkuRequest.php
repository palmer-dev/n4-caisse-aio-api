<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeSkuRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'product_attribute_id' => ['required', 'exists:product_attributes'],
			'sku_id'               => ['required', 'exists:skus'],
			'value'                => ['required'],
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
