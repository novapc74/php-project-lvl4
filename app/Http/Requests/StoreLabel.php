<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabel extends FormRequest
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
        if ($this->method() == 'PATCH') {
            $nameRule = ['required', 'string'];
        } else {
            $nameRule = ['required', 'string', 'unique:labels'];
        }
        return [
            'name' => $nameRule,
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('The label has already been taken.'),
        ];
    }
}
