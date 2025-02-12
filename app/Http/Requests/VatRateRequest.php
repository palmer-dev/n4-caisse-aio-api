<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VatRateRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'name'        => ['required'],
			'description' => ['required'],
			'value'       => ['required', 'numeric'],
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
