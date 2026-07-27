<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'product_code' => 'nullable|string|max:5|unique:products,product_code,'.$this->route('product'),
            'brand_id' => 'required|exists:brands,id',
            'price' => 'nullable|numeric|min:0',
            'ChassisNumber' => 'nullable|string|max:255',
            'EngineNumber' => 'nullable|string|max:255',
            'Color' => 'nullable|string|max:255',
            'PurchasePrice' => 'nullable|numeric|min:0',
            'WD' => 'nullable|string|max:255',
            'CC' => 'nullable|integer',
            'Transmission' => 'nullable|string|max:255',
            'PickupYard' => 'nullable|string|max:255',
            'Supplier' => 'nullable|string|max:255',
            'ODOMeter' => 'nullable|string|max:255',
            'Score' => 'nullable|numeric|min:0',
            'AuctionGrade' => 'nullable|string|max:255',
            'InvoiceNumber' => 'nullable|string|max:255',
            'Status' => 'nullable|integer',
            'Remarks' => 'nullable|string|max:255',

            'Year' => 'nullable|numeric|min:0',

        ];
    }
}
