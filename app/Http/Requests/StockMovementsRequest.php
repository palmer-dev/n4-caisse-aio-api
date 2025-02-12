<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockMovementsRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'sku_id'        => ['required', 'exists:skus'],
			'quantity'      => ['required', 'integer', 'min:0'],
			'movement_type' => ['required'],
			'description'   => ['nullable'],
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
