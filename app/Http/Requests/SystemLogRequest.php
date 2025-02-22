<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemLogRequest extends FormRequest
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
                    'name' => "required|string|unique:roles,name",
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'name' => "required|string|unique:roles,name,{$this->dataId}",
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
