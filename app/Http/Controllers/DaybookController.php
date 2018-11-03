<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\Purchase;
use App\Item;
use App\Godown;
use App\Slip;
use App\Invoice;

class DaybookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 	
	
    public function view($dateString = null, $item='All')
    {
		if(!isset($dateString))
			$date = date('Y-m-d');
		else
			$date = date('Y-m-d',strtotime($dateString));
		
		if($item == 'All')
		{
			$slips = Slip::where('date',$date)->get();
			$invoices = Invoice::where('date',$date)->get();			
			$purchases = Purchase::where('date',$date)->get();			
		}
		else
		{
			$slips = Slip::where('date',$date)
						   ->whereHas('order', function($q) use ($item) {$q->where('item_id', $item);})
						   ->get();
			$invoices = Invoice::where('date',$date)
							->whereHas('order', function($q) use ($item) {$q->where('item_id', $item);})
						   ->get();				
			$purchases = Purchase::where('date',$date)
							->where('item_id',$item)
						   ->get();										   
		}

		$items = Item::all();
		
		return view('daybook',compact('slips','invoices','purchases','items','item','date'));
    }    
}
