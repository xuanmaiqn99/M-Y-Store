<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'avatar' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:12288',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('Bạn chưa nhập tiêu đề'),
            'content.required' => __('Bạn chưa nhập nội dung'),
            'avatar.required' => __('Bạn chưa nhập ảnh'),
            'avatar.mimes' => __('Không đúng định dạng ảnh'),
            'avatar.max' => __('Ảnh tối đa 12MB'),
        ];
    }
}
