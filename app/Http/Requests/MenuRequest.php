<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => "required|string",
                    'route' => "string|nullable",
                    'icon' => "required|string|nullable",
                    'sorting' => "numeric|nullable",
                    'parent_id' => "numeric|nullable",
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'name' => "required|string",
                    'route' => "string|nullable",
                    'icon' => "required|string|nullable",
                    'sorting' => "numeric|nullable",
                    'parent_id' => "numeric|nullable",
                ];
                break;
        }
    }
    public function messages()
    {
        return [
            'name.required'=>'Please Enter Role Name',
            'name.unique'=>'Role Name Already Exists',
        ];
    }
}
