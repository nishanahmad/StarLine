<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slip extends Model
{
	protected $guarded = ['id'];
	
    public function user()
    {
        return $this->belongsTo('App\User');
    }
	
    public function godown()
    {
        return $this->belongsTo('App\Godown');
    }	
	
    public function order()
    {
        return $this->belongsTo('App\Order');
    }		
	
    /*
     * This function returns false if the sum of quantities of all child slips exceed the quantity of the parent order.
	 */		
    public function checkQty($orderId,$qty)
    {
		$order = Order::whereId($orderId)->firstOrFail();
        $slipsQty = $order -> slips() -> sum('qty') + $qty;
		
		if($slipsQty > $order -> qty)
			return false;
		else
			return true;
    }	
}
