<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:12288',
            'image_id[]' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:12288',
            'descript' => 'required',
            'size' => 'required',
            'color' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Bạn chưa nhập tên'),
            'descript.required' => __('Bạn chưa nhập mô tả'),
            'size' => __('Bạn chưa nhập kích cỡ'),
            'color' => __('Bạn chưa nhập màu'),
            'price.required' => __('Bạn chưa nhập giá'),
            'avatar.mimes' => __('Ảnh không đúng định dạng'),
            'avatar.max' => __('Ảnh tối đa 12MB'),
            'image_id[].mimes' => __('Ảnh không đúng định dạng'),
            'image_id[].max' => __('Ảnh tối đa 12MB'),
        ];
    }
}
