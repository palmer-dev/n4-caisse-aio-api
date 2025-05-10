<?php

namespace App\Http\Requests;

use App\Enums\PermissionsEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ComputeSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can( PermissionsEnum::CREATE_SALES );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "skus"            => ["array"],
            "skus.*.sku"      => ["required", "exists:skus,sku"],
            "skus.*.quantity" => ["required", "integer", "min:1"],
        ];
    }
}
