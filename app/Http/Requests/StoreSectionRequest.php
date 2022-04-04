<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
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
            'section_name' => 'required|string|unique:sections|max:255',
            'description'  => 'string',
        ];
    }

    public function messages()
    {
        return [
            'section_name.required' => 'اسم القسم مطلوب',
            'section_name.string' => 'اسم القسم يجب ان يكون نص',
            'section_name.unique' => 'اسم القسم موجود يجب ادخال اسم اخر',
            'section_name.max' => 'طول الاسم يجب ان لا يتعدي 255 حرف',
            'description.string' => 'وصف القسم يجب ان يكون نص',

        ];
    }
}
