<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InvoiceFormRequest;
use App\Invoice;
use App\Order;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 	
	
    public function index()
    {
		$invoices = Invoice::all()-> sortByDesc('date');
		
		return view('invoices.index',compact('invoices')); 
    }    
	
    public function create($orderId)
    {
		$today = date('Y-m-d');
		$order = Order::whereId($orderId)->firstOrFail();
		
		return view('invoices.create',compact('today','order')); 
    }
	
    public function store(InvoiceFormRequest $request)
    {
		$order = Order::whereId($request->get('order'))->firstOrFail();
		
		$invoice = new Invoice(array(
			'date' => date('Y-m-d',strtotime($request->get('date'))),
			'order_id' => $request->get('order'),		
			'qty' => $request->get('qty'),
			'number' => $request->get('number'),
			'user_id' => Auth::user() -> id
        ));
		
		if($invoice -> checkQty($request->get('order'),$request->get('qty')))
		{
			try{
				DB::beginTransaction();
				$invoice->save();
				$status = $order -> updateStatus();
				if($status == null)
				{
					DB::commit();
					return redirect('/orders/'.$request->get('order'))->with('success', 'Invoice has been succesfully created!');
				}
				else
				{
					DB::rollback();
					return redirect()-> back() ->with('error', 'Error!!! Please contact admin with this message : '.$status) -> withInput();						
				}
			}	
			catch(\Exception $e){			
				if (strpos($e->getMessage(), 'Duplicate entry') !== false)
					return redirect()-> back() ->with('error', 'Error!!! Duplicate invoice number found for another invoice') -> withInput();						
				else	
					return redirect()-> back() ->with('error', 'Error!!! Please contact admin with this message : '.$e->getMessage()) -> withInput();						
			}			
		}
		else
			return redirect()-> back() ->with('error', 'Error!!! Quantiy of invoices exceeded for this order.') -> withInput();									

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
