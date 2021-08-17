<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Astrotomic\Translatable\Validation\RuleFactory;

class ContactRequest extends FormRequest
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
        $rules =  [
            '%name%' =>'required',
            'address'=>'required',
            'city'=>'required',
        ];

        $rules = RuleFactory::make($rules, RuleFactory::FORMAT_ARRAY );

        return $rules;
    }
}
