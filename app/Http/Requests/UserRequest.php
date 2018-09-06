<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [];
        $rules['name'] = 'required|string|max:255';

        if($this->method()=='POST'){
            $rules['email'] = 'required|string|email|max:255|not_in:rocky@lenderhomepage.com|unique:users';
            $rules['password'] = 'required|string|min:6|confirmed';
        } elseif($this->method()=='PUT' || $this->method()=='PATCH'){
            $rules['email'] = 'required|string|email|max:255|not_in:rocky@lenderhomepage.com|unique:users,id,'.$this->route('user');
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'email.not_in' => 'rocky@lenderhomepage.com is the only administrator and can NOT be modified!',
        ];
    }
}
