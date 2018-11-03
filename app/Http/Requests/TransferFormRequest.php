<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TransferFormRequest extends FormRequest
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
			'item' => 'digits_between:1,100|required',
			'qty'=> 'digits_between:1,100000|required',
			'from'=> 'digits_between:1,100|required',
			'to'=> 'digits_between:1,100|required',
			'from' => 'different:to'

        ];
    }
	
    public function messages()
    {
        return [
            'date.required' => 'Date is required!',
            'item.required' => 'Item is required!',
			'qty.digits_between' => 'Input a valid number for quantity!',
			'qty.required' => 'Quantity is required!',
			'from.required' => 'From godown is required!',
			'from.digits_between' => 'Please select a valid FROM GODOWN !',
			'to.required' => 'To godown is required!',
			'from.different' => 'Both godowns cannot be same.'
        ];
    }
	
}
