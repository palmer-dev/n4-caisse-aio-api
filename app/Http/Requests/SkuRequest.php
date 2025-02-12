<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkuRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'product_id'    => ['required', 'exists:products'],
			'sku'           => ['required'],
			'slug'          => ['required'],
			'currency_code' => ['required'],
			'unit_amount'   => ['required', 'numeric'],
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
