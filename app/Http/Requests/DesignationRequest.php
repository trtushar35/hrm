<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string'
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'name' => 'required|string'
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
 			

        ];
    }
}
