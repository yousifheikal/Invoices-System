<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // Validate data coming request
            'invoice_number' => 'required',
            'Rate_VAT' => 'required',
            'product' => 'required',
            'section' => 'required',
//            'Value_VAT' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            // Type of error u wants show
            'invoice_number.required' =>'يرجي ادخال رقم الفاتورة',
            'product.required' =>'يرجي ادخال القسم',
            'section.required' =>'يرجي ادخال المنتج',
            'Rate_VAT.required' =>'يرجي ادخال نسبة ضريبة القيمة المضافة',
//            'Value_VAT.required' =>'يرجي ادخال  ضريبة القيمة المضافة',
            'Amount_collection.required' =>'يرجي ادخال مبلغ تحصيل المال',
        ];
    }
}
