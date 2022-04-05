<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'Product_name' => 'required|string|max:999',
            'description'  => 'string',
            'section_id'   =>'required',
        ];
    }

    public function messages()
    {
        return [
            'Product_name.required' => 'اسم المنتج مطلوب',
            'Product_name.string' => 'اسم المنتج يجب ان يكون نص',
            'Product_name.max' => 'طول الاسم يجب ان لا يتعدي 999 حرف',
            'description.string' => 'وصف المنتج يجب ان يكون نص',
            'section_id.required'        => 'حقل القسم مطلوب',

        ];
    }
}
