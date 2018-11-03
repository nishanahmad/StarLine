<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];
	
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
	
    public function item()
    {
        return $this->belongsTo('App\Item');
    }	
	
	public function invoices()
	{
		return $this->hasMany('App\Invoice')->get();
	}	

	public function slips()
	{
		return $this->hasMany('App\Slip')->get();
	}		
	
	public function updateStatus()
	{
		$orderQty = $this->qty;
		
		$invoicetotal = 0;
		$invoices = $this -> invoices();
		foreach($invoices as $invoice)
			$invoicetotal = $invoicetotal + $invoice -> qty;
		
		$sliptotal = 0;
		$slips = $this -> slips();
		foreach($slips as $slip)
			$sliptotal = $sliptotal + $slip -> qty;
		
		if($orderQty == $invoicetotal && $invoicetotal == $sliptotal)
		{
			$this -> status = 'Closed';
			try{
				$this -> save();		
				return null;
			}
			catch(\Exception $e){
				return ($e->getMessage());
			}
		}
	}			
}
