<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'date' => 'date|required',
			'item'=> 'digits_between:1,100|required',
			'qty'=> 'digits_between:1,100000|required',
			'number'=> 'digits_between:1,1000000|required',
			'slip_number'=> 'digits_between:1,1000000|required',
			'godown'=> 'digits_between:1,100|required'
        ];
    }
	
    public function messages()
    {
        return [
            'date.required' => 'Date is required!',
            'item.required' => 'Item is required!',
            'item.digits_between' => 'Input a Item!',
			'qty.digits_between' => 'Input a valid number for quantity!',
			'qty.required' => 'Quantity is required!',
            'number.required' => 'Delivery number is required!',
            'number.digits_between' => 'Delivery number is not a valid number!',			
            'slip_number.required' => 'Slip number is required!',
            'slip_number.digits_between' => 'Slip number is not a valid number!',						
			'godown.required' => 'Godown is required!',			
			'godown.digits_between' => 'Select a valid godown!'			
        ];
    }	
}
