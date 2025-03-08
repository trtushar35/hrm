<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|unique:admins,email|max:255',
                    'photo' => 'nullable|file|mimes:png,jpg,jpeg|max:25048',
                    'phone' => 'nullable|string|max:20',
                    'sorting' => 'nullable|numeric',
                    'address' => 'nullable|string',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                    'salary' => 'required',
                    'hiring_date' => 'required',
                    'joining_date' => 'required',
                ];
                break;

            case 'PUT':
                return [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|unique:admins,email|max:255',
                    'photo' => 'nullable|file|mimes:png,jpg,jpeg|max:25048',
                    'phone' => 'nullable|string|max:20',
                    'sorting' => 'nullable|numeric',
                    'address' => 'nullable|string',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                    'salary' => 'required',
                    'hiring_date' => 'required',
                    'joining_date' => 'required',
                ];
                break;
            case 'PATCH':

                break;
        }
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {

        return [
            'first_name.required' => __('The first name field is required.'),
            'last_name.required' => __('The last name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.email' => __('Please enter a valid email address.'),
            'email.unique' => __('This email address is already taken.'),
            'photo.file' => __('The photo must be a file.'),
            'photo.mimes' => __('The photo must be a file of type: png, jpg, jpeg.'),
            'photo.max' => __('The photo may not be greater than :max kilobytes.'),
            'phone.max' => __('The phone number may not be greater than :max characters.'),
            'sorting.numeric' => __('The sorting must be a number.'),
            'department_id.required' => __('The department field is required.'),
            'designation_id.required' => __('The designation field is required.'),
            'salary.required' => __('The salary field is required.'),
        ];
    }
}
