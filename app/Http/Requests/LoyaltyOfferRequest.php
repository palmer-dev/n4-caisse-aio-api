<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoyaltyOfferRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'points'     => ['required', 'integer'],
			'start_date' => ['required', 'date'],
			'end_date'   => ['nullable', 'date'],
			'is_active'  => ['required', 'boolean'],
			'shop_id'    => ['required', 'exists:shops'],
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
