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
            $nameRule = ['required', 'string'];
        } else {
            $nameRule = ['required', 'string', 'unique:tasks'];
        }

        return [
            'name' => $nameRule,
            'description' => ['nullable', 'string', 'max:255'],
            'status_id' => ['required', 'exists:task_statuses,id'],
            'assigned_to_id' => ['nullable', 'exists:users,id']
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('The task has already been taken.'),
        ];
    }
}
