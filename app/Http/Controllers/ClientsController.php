<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Invoice;
use App\Slip;
use App\Item;
use App\Godown;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 	
	
    public function balance()
    {	
		$slips = Slip::whereHas('order', function($q){$q->where('status', 'Pending');})->get();
		$invoices = Invoice::whereHas('order', function($q){$q->where('status', 'Pending');})->get();
		
		$clientMap = array();
		
		foreach($slips as $slip)
		{
			if(isset($clientMap[$slip->order->client->name]))
				$clientMap[$slip->order->client->name] = $clientMap[$slip->order->client->name] + $slip->qty;
			else
				$clientMap[$slip->order->client->name] = $slip->qty;
		}
		
		foreach($invoices as $invoice)
		{
			if(isset($clientMap[$invoice->order->client->name]))
				$clientMap[$invoice->order->client->name] = $clientMap[$invoice->order->client->name] - $invoice->qty;
			else
				$clientMap[$invoice->order->client->name] = -$invoice->qty;
		}		
		ksort($clientMap);
		return view('clients.balance',compact('clientMap'));
    }    
}
