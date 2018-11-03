<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TransferFormRequest;
use App\Stock;
use App\Invoice;
use App\Slip;
use App\Item;
use App\Godown;
use App\TransferLog;
use App\Traits\StockUpdates;

class StockController extends Controller
{
	use StockUpdates;
	
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function itemStock($dateString = null, $item=null)
    {
		if(!isset($dateString))
			$date = date('Y-m-d');
		else
			$date = date('Y-m-d',strtotime($dateString));
		
		if($item == null)
		{
			$items = Item::all();
			$item = $items -> first()->id;
		}
		
		$godowns = Godown::all();
		$godownQtyMap = array();
		foreach($godowns as $godown)
		{
			$stock = Stock::where('date','<=',$date)
					->where('item_id',$item)
					->where('godown_id',$godown->id)
					->orderBy('date','DESC')
					->first();

			$godownQtyMap[$godown->name] = $stock['closing'];			
		}
		
		$invoices = Invoice::where('date','<=',$date)
						->whereHas('order', function($q) use ($item) {$q->where('item_id', $item);})
						->whereHas('order', function($q) {$q->where('status', 'Pending');})
						->get();
		$slips = Slip::where('date','<=',$date)
						->whereHas('order', function($q) use ($item) {$q->where('item_id', $item);})
						->whereHas('order', function($q) {$q->where('status', 'Pending');})
						->get();						
		
		foreach($invoices as $invoice)
		{
			if(isset($clientMap[$invoice->order->client->name]))
				$clientMap[$invoice->order->client->name] = $clientMap[$invoice->order->client->name] - $invoice->qty;
			else
				$clientMap[$invoice->order->client->name] = - $invoice->qty;
		}
		
		$clientMap = array();
		foreach($slips as $slip)
		{
			if(isset($clientMap[$slip->order->client->name]))
				$clientMap[$slip->order->client->name] = $clientMap[$slip->order->client->name] + $slip->qty;
			else
				$clientMap[$slip->order->client->name] = $slip->qty;			
		}
		
		$items = Item::all();
		
		return view('stock.item',compact('godownQtyMap','clientMap','date','item','items'));
    }
	
	public function transferView()
	{
		$godowns = Godown::all();
		$today = date('Y-m-d');
		$items = Item::all();
		
		return view('stock.transfer',compact('godowns','today','items'));
	}
	
	public function transfer(TransferFormRequest $request)
	{
		$date = date('Y-m-d',strtotime($request->get('date')));
		$item = $request->get('item');
		$qty = $request->get('qty');
		$from = $request->get('from');
		$to = $request->get('to');
		$remarks = $request->get('remarks');
		$fromGodown = Godown::whereId($from)->firstOrFail();
		
		DB::beginTransaction();

		try{
			$fromError = $this -> addStock($date,$from,$item,-$qty);
			if($fromError == null)
				$toError = $this -> addStock($date,$to,$item,$qty);
		}
		catch(\Exception $e){
			DB::rollback();
				
			if($fromError != null)
				return redirect()-> back() ->with('error', 'Not enough stock in '.$fromGodown->name.' to transfer') -> withInput();													
			else
				return redirect()-> back() ->with('error', 'Unknown error.Please contact admin with the following message : '.$e->getMessage()) -> withInput();													
		}
		
		if($fromError == null && $toError == null)
		{		
			try{
				$transferLog = new TransferLog(array(
					'date' => $date,		
					'item_id' => $item,		
					'qty' => $qty,
					'from' => $from,
					'to' => $to,
					'remarks' => $remarks,
					'user_id' => Auth::user() -> id
				));
				
				$transferLog -> save();
				
				DB::commit();
				return redirect()->back()->with('success', 'Transfer Success!!!');				
			}
			catch(\Exception $e){
				DB::rollback();
				return redirect()-> back() ->with('error', 'Error!!! Please contact admin with this message : '.$e->getMessage()) -> withInput();								
			}			
		

		}
		else
		{
			DB::rollback();
			if($fromError != null)
				return redirect()-> back() ->with('error', 'Not enough stock in '.$fromGodown->name.' to transfer') -> withInput();													
			else			
				return redirect()-> back() ->with('error', 'Error!!! An unknown error occured. Please contact admin') -> withInput();							
		}
			
	}

	public function transferLogs()
	{
		$godowns = Godown::all();
		foreach($godowns as $godown)
		{
			$godownNameMap[$godown['id']] = $godown['name'];
		}
		
		$logs = TransferLog::all();
		
		return view('stock.transferLogs',compact('logs','godownNameMap'));
	}	
}