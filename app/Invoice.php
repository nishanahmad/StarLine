<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	protected $guarded = ['id'];
	
    public function user()
    {
        return $this->belongsTo('App\User');
    }
	
    public function order()
    {
        return $this->belongsTo('App\Order');
    }		
	
    /*
     * This function returns false if the sum of quantities of all child invoices exceed the quantity of the parent order.
	 */		
    public function checkQty($orderId,$qty)
    {
		$order = Order::whereId($orderId)->firstOrFail();
        $invoiceQty = $order -> invoices() -> sum('qty') + $qty;
		
		if($invoiceQty > $order -> qty)
			return false;
		else
			return true;
    }	
}
