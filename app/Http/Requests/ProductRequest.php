<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use \Astrotomic\Translatable\Validation\RuleFactory;

class ProductRequest extends FormRequest
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
            'product_code' => 'required',
            'product_type' => 'required',
            '%name%' =>'required',
            '%description%' => 'required',
        ];

        $rules = RuleFactory::make($rules, RuleFactory::FORMAT_ARRAY );

        return $rules;
    }
}
