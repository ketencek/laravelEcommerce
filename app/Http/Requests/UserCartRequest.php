<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserCartRequest extends FormRequest
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
             'product_id' => 'required',
            //  'customer_id' => 'required',
            //  'color_id' => 'required',
            //  'currency_id' => 'required',
            //  'price' => 'required',
            //  'main_price' => 'required',
            //  'product_discount_per' => 'required',
            //  'discount_code' => 'required',
            //  'discount_per' => 'required',
            //  'discount_code' => 'required',
            //  'quantity' => 'required',
        ];
    }
}
