<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderFormRequest;
use App\Http\Requests\OrderSearchRequest;
use Illuminate\Http\Request;
use App\Order;
use App\Client;
use App\Item;
use App\Invoice;
use App\Slip;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 	
	
    public function index()
    {	
		$clients = Client::all()->sortBy('name');
		
		return view('orders.index',compact('clients')); 
    }    
	
    public function search(OrderSearchRequest $request)
    {	
		$query = Order::where('id','>',0);
		$requests = $request -> all();
		foreach($requests as $key => $value)
		{
			if (!empty($value) && $key != '_token') 
			{
				if($key == 'from')
				{
					$query->where('date','>=',date('Y-m-d',strtotime($value)));
					$from = $value;
				}
					
				else if($key == 'to')
				{
					$query->where('date','<=',date('Y-m-d',strtotime($value)));							
					$to = $value;
				}
					
				else
				{
					$query->where($key,$value);							
					$client = Client::where('id',$value)->firstorFail();
				}
					
			}
		}
		$orders = $query->get();
		
		return view('orders.indexFiltered',compact('orders','from','to','client')); 
    }    	
	
    public function pending()
    {
		$orders = Order::where('status','Pending') -> get() -> sortBy('date');
		
		$orderQty = $orders->sum('qty');
		$invoicedQty =0;
		$slippedQty = 0;
		foreach($orders as $order)
		{
			$invoicedQty = $invoicedQty + $order -> invoices()->sum('qty');
			$slippedQty = $slippedQty + $order -> slips()->sum('qty');
		}

		$invoicePending = $orderQty - $invoicedQty;
		$slipPending = $orderQty - $slippedQty;
		
		return view('home',compact('orders','invoicePending','slipPending')); 
    }    	
	
    public function create()
    {
		$today = date('Y-m-d');
		$clients = Client::all() -> sortBy('name');
		$items = Item::all() -> sortBy('name');
		return view('orders.create',compact('clients','items','today')); 
    }
	
    public function store(OrderFormRequest $request)
    {
		$order = new Order(array(
			'date' => $request->get('date'),		
            'client_id' => $request->get('client'),
			'item_id' => $request->get('item'),			
			'qty' => $request->get('qty'),
			'remarks' => $request->get('remarks'),
			'user_id' => Auth::user() -> id
        ));
			
		try{
			$order->save();	
			return redirect('orders/'.$order->id)->with('success', 'Order has been succesfully created!');
		}	
		catch(\Exception $e){
			return redirect()-> back() ->with('error', 'Error!!! Please contact admin with this message : '.$e->getMessage());			
		}
	}

    public function show($id)
    {
		$order = Order::whereId($id)->firstOrFail();
		$invoices = $order -> invoices() -> sortBy('date');
		$slips = $order -> slips() -> sortBy('date');

		return view('orders.show', compact('order','invoices','slips'));
    }	
	
    public function edit($id)
    {
		$order = Order::whereId($id)->firstOrFail();
		$clients = Client::all() -> sortBy('name');
		$items = Item::all() -> sortBy('name');

		return view('orders.edit', compact('order','clients','items'));
    }		
	
    public function update(OrderFormRequest $request, $id)
    {
		$order = Order::whereId($id)->firstOrFail();
		$order -> date = $request->get('date');
		$order -> client_id = $request->get('client');
		$order -> item_id = $request->get('item');
		$order -> qty = $request->get('qty');
		$order -> remarks = $request->get('remarks');		
		
		$invoicedQty = $order -> invoices()->sum('qty');
		$slippedQty = $order -> slips()->sum('qty');
		if($invoicedQty == $slippedQty && $slippedQty == $order -> qty)
			$order -> status = 'Closed';		
		else
			$order -> status = 'Pending';		
			
		try{
			$order -> save();
			return redirect('orders/'.$order -> id)->with('success', 'Success!!!Order updated successfully!');								
		}	
		catch(\Illuminate\Database\QueryException $e){
			return redirect()->back()->with('error', 'Error!!! Please contact admin with the following error detail :<br><br>'.$e->getMessage());								
		}
    }			

    public function destroy($id)
    {
		$invoices = Invoice::where('order_id', $id)->get();
		$slips = Slip::where('order_id', $id)->get();
		if($invoices -> count() > 0 || $slips -> count() > 0)
			return redirect()->back()->with('error', 'Cannot delete orders with invoices or slips !!!');
		else
		{
			$order = Order::whereId($id)->firstOrFail();
			$order -> delete();
			return redirect('orders')->with('success','Order Deleted successfully !!!');
		}
    }				
}