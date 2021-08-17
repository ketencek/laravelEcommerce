<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

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
        return [
             'first_name' => 'required',
             'last_name' =>'required',
             'email'=> 'required|email|unique:users,email,'.$this->id,
             'password' => 'min:4|required_with:password_confirmation|same:password_confirmation',
             'password_confirmation' => 'min:4'
        ];
    }
}
