<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
                    'name' => "required|string|unique:permissions,name",
                    'guard_name' => "required|string",
                    'parent_id' => "nullable",
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'name' => "required|string",
                    'guard_name' => "required|string",
                    'parent_id' => "nullable",
                ];
                break;
        }
    }
    public function messages()
    {
        return [
            'name.required'=>'Please Enter Permission Name',
            'name.unique'=>'Permission Name Already Exists',
        ];
    }
}
