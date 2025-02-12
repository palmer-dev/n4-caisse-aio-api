<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'sku_id'   => ['required', 'exists:skus'],
			'quantity' => ['required', 'integer'],
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
