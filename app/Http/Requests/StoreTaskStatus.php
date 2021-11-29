<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskStatus extends FormRequest
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
            'name' => ['required', 'string', 'unique:task_statuses', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('The status has already been taken.'),
            'name.max' => __('The name length cannot be more than 255'),
        ];
    }
}
