<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTask extends FormRequest
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
            $nameRule = ['required', 'string', 'max:255'];
        } else {
            $nameRule = ['required', 'string', 'unique:tasks', 'max:255'];
        }

        return [
            'name' => $nameRule,
            'description' => ['nullable', 'string'],
            'status_id' => ['required', 'exists:task_statuses,id'],
            'assigned_to_id' => ['nullable', 'exists:users,id']
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('The task has already been taken.'),
            'name.max' => __('The name length cannot be more than 255'),
        ];
    }
}
