<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'category_id' => ['required', 'exists:categories'],
			'vat_rate_id' => ['required', 'exists:vat_rates'],
			'shop_id'     => ['required', 'exists:shops'],
			'type'        => ['required'],
			'name'        => ['required'],
			'slug'        => ['required', 'unique:products,slug'],
			'description' => ['nullable'],
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
