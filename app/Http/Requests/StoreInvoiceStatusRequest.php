<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|string',
            'payment_date' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
                'status.required'=>'حقل حالة الفاتورة مطلوب',
                'status.string'=>'حقل حالة الفاتورة يجب ان يكون من نوع نص',
                'payment_date.required'=>'حقل تاريخ الدفع مطلوب',
                'payment_date.string'=>'حقل تاريخ الدفع يجب ان يكون من نوع نص',
        ];
    }
}
