<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
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
			'client' => 'digits_between:1,100000|required',
			'item' => 'digits_between:1,100|required',
			'qty'=> 'digits_between:1,100000|required',
        ];
    }
	
    public function messages()
    {
        return [
            'date.required' => 'Date is required!',
            'client.required' => 'Client is required!',
            'item.required' => 'Item is required!',
			'qty.digits_between' => 'Input a valid number for quantity!',
			'qty.required' => 'Quantity is required!'
        ];
    }
	
}
