<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleDetailRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'sale_id'    => ['required', 'exists:sales'],
			'sku_id'     => ['required', 'exists:skus'],
			'quantity'   => ['required', 'integer'],
			'unit_price' => ['required', 'integer'],
			'vat'        => ['required', 'numeric'],
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
