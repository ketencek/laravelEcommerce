<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class RegistrationRequest extends FormRequest
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
            'fullname' => 'required',
            'email' => 'required',
            'number' => 'required',
            'landline' => 'required',
            'bussiness_name' => 'required',
            'billing_name' => 'required',
            'billing_address' => 'required',
            'billing_country_id' => 'required',
            'billing_state_id' => 'required',
            'billing_cities_id' => 'required',
            'is_same' => 'required',
            'gst_no' => 'required',
            'type_of_bussiness' => 'required',
            'password' => 'required',
        ];
    }
}