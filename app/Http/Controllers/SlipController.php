<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SlipFormRequest;
use App\Http\Controllers\StockController;
use App\Traits\StockUpdates;
use App\Slip;
use App\Order;
use App\Godown;

class SlipController extends Controller
{
	use StockUpdates;
	
    public function __construct()
    {
        $this->middleware('auth');
    } 	
	
    public function index()
    {
		$slips = Slip::all()-> sortByDesc('date');
		
		return view('slips.index',compact('slips')); 
    }    
	
    public function create($orderId)
    {
		$today = date('Y-m-d');
		$godowns = Godown::all();
		$order = Order::whereId($orderId)->firstOrFail();
		
		return view('slips.create',compact('today','order','godowns')); 
    }
	
    public function store(SlipFormRequest $request)
    {
		$order = Order::whereId($request->get('order'))->firstOrFail();
		
		$slip = new Slip(array(
			'date' => date('Y-m-d',strtotime($request->get('date'))),
			'order_id' => $order->id,		
			'qty' => $request->get('qty'),
			'number' => $request->get('number'),
			'lorry' => $request->get('lorry'),
			'driver' => $request->get('driver'),
			'time' => $request->get('time'),
			'godown_id' => $request->get('godown'),
			'user_id' => Auth::user() -> id
        ));

		if($slip -> checkQty($order->id,$request->get('qty')))
		{
			DB::beginTransaction();

			try{
				$slip->save();	
			}
			catch(\Exception $e){
				DB::rollback();
				if (strpos($e->getMessage(), 'Duplicate entry') !== false)
					return redirect()-> back() ->with('error', 'Error!!! Duplicate slip number found for another godown slip') -> withInput();							
				else
					return redirect()-> back() ->with('error', 'Error!!! Please contact admin with this message : '.$e->getMessage()) -> withInput();								
			}

			try{
				$order -> updateStatus();
			} 
			catch(\Exception $e){
				DB::rollback();
				return redirect()-> back() ->with('error', 'Error!!! Please contact admin with this message : '.$e->getMessage()) -> withInput();								
			}
			
			try{
				$stockError = $this -> addStock($slip->date,$slip->godown_id,$slip->order->item_id,-$slip->qty);
			}
			catch(\Exception $e){
				DB::rollback();
				return redirect()-> back() ->with('error', 'Error!!! Please contact admin with this message : '.$e->getMessage()) -> withInput();								
			}			
			
			if($stockError == null)
			{
				DB::commit();
				return redirect('orders/'.$order->id)->with('success', 'Slip has been succesfully created!');
			}
			else
				return redirect()-> back() ->with('error', 'Error!!! Not enough stock in the godown. Please enter purchase first.') -> withInput();								
		}
		else
			return redirect()-> back() ->with('error', 'Error!!! Quantiy of slips exceeded for this order.') -> withInput();						
	}

    public function show($id)
    {
		$invoice = Invoice::whereId($id)->firstOrFail();

		return view('invoices.show', compact('invoice','$order'));
    }	

    public function destroy($id)
    {
		/*
		
		Only cancel invoices. Dont allow deletion
		
		$invoices = Invoice::where('order_id', $id)->get();
		$slips = Slip::where('order_id', $id)->get();
		if($invoices -> count() > 0 || $slips -> count() > 0)
			return redirect()->back()->with('error', 'Cannot delete orders with invoices or slips !!!');
		else
		{
			$house = House::whereId($id)->firstOrFail();
			$houseName = $house -> name;
			$house -> delete();
			return redirect('houses')->with('status', $houseName . ' was deleted successfully !!!');
		}
		*/
    }
}
