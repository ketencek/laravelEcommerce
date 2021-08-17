<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Astrotomic\Translatable\Validation\RuleFactory;

class StaticPageRequest extends FormRequest
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
            'cat_type' => 'required',
            '%title%' =>'required',
            '%sub_title%' => 'required',
            // '%short_description%' => 'required',
            '%description%' => 'required',
        ];

        $rules = RuleFactory::make($rules, RuleFactory::FORMAT_ARRAY );

        return $rules;
        // $rules = RuleFactory::make([
        //     '%title%' => 'sometimes|string',
        //     'translations.%content%' => ['required_with:translations.%title%', 'string'],
        // ]);
        
        // $validatedData = $request->validate($rules);
    }
}
