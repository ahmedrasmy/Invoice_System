<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'invoice_number' => 'required|string|max:50',
            'invoice_date'  => 'required|date',
            'due_date'  => 'required|date',
            'product'  => 'required|string|max:50',
            'amount_collection'  => 'numeric|digits_between:1,8',
            'amount_commission'  => 'required|numeric|digits_between:1,8',
            'discount'  => 'required|numeric|digits_between:1,8',
            'value_vat'  => 'required|numeric|digits_between:1,8',
            'rate_vat' => 'required|string',
            'total'  => 'required|numeric|digits_between:1,8',
            'pic' =>'image|mimes:jpg,bmp,jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'invoice_number.required' => 'رقم الفاتورة مطلوب',
            'invoice_number.string' => 'رقم الفاتورة يجب ان يكون نص',
            'invoice_number.max' => 'طول رقم الفاتورة يجب ان لا يتعدي 50 حرف',
            'invoice_date.required' => 'يجب ادخال تاريخ الفاتورة',
            'invoice_date.date' => 'يجب ادخال الحقل من النوع تاريخ',
            'due_date.required' => 'يجب ادخال تاريخ الاستحقاق',
            'due_date.date' => 'يجب ادخال الحقل من النوع تاريخ',
            'product.required' => ' اسم المنتج مطلوب',
            'product.string' => 'اسم المنتج  يجب ان يكون نص',
            'product.max' => 'طول اسم المنتج يجب ان لا يتعدي 50 حرف',
            'description.string' => 'وصف المنتج يجب ان يكون نص',
            'section_id.required'        => 'حقل القسم مطلوب',
            'amount_collection.numeric' => 'مبلغ التحصيل يجب ان يكون رقم',
            'amount_collection.digits_between' =>'مبلغ التحصيل يجب ان لايتعدي 8 ارقام',
            'amount_commission.required' => 'مبلغ العمولة مطلوب',
            'amount_commission.numeric' => 'مبلغ العمولة يجب ان يكون رقم',
            'amount_commission.digits_between' =>'مبلغ العمولة يجب ان لايتعدي 8 ارقام',
            'discount.required' => 'مبلغ الخصم مطلوب',
            'discount.numeric' => 'مبلغ الخصم يجب ان يكون رقم',
            'discount.digits_between' =>'مبلغ الخصم يجب ان لايتعدي 8 ارقام',
            'value_vat.required' => 'قيمة ضريبة القيمة المضافة  مطلوب',
            'value_vat.numeric' => 'قيمة ضريبة القيمة المضافة  يجب ان يكون رقم',
            'value_vat.digits_between' =>'قيمة ضريبة القيمة المضافة  يجب ان لايتعدي 8 ارقام',
            'rate_vat.required' => 'قيمة ضريبة القيمة المضافة  مطلوب',
            'rate_vat.string' => 'قيمة ضريبة القيمة المضافة  يجب ان يكون نص',
            'rate_vat.max' =>'قيمة ضريبة القيمة المضافة  يجب ان لايتعدي 8 حروف',
            'total.required' => 'مبلغ الكلي مطلوب',
            'total.numeric' => 'مبلغ الكلي يجب ان يكون رقم',
            'total.digits_between' =>'مبلغ الكلي يجب ان لايتعدي 8 ارقام',
            'pic.image' =>'حقل الصورة يجب ان من النوع image',
            

        ];
    }
}
