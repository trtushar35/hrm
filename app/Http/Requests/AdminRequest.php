<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|unique:admins,email|max:255',
                    'photo' => 'file|mimes:png,jpg,jpeg|max:25048',
                    'phone' => 'nullable|string|max:20',
                    'role_id' => 'required|exists:roles,id',
                    'password' => 'required|string|min:8',
                    'sorting' => 'nullable|numeric',
                    'address' => 'nullable|string',
                ];
                break;

            case 'PUT':
                return [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:admins,id,' . $this->id,
                    'photo' => 'nullable|file|mimes:png,jpg,jpeg|max:25048',
                    'phone' => 'nullable|string|max:20',
                    'role_id' => 'required|exists:roles,id',
                    'password' => 'nullable|string|min:8',
                    'sorting' => 'nullable|numeric',
                    'address' => 'nullable|string',
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
            'role_id.required' => __('The role field is required.'),
            'role_id.exists' => __('Selected role does not exist.'),
            'password.min' => __('The password must be at least :min characters.'),
            'sorting.numeric' => __('The sorting must be a number.'),
        ];
    }
}
