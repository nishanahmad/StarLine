<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PurchaseFormRequest;
use App\Traits\StockUpdates;
use Illuminate\Http\Request;
use App\Purchase;
use App\Item;
use App\Godown;

class PurchaseController extends Controller
{
	use StockUpdates;
	
    public function __construct()
    {
        $this->middleware('auth');
    } 	
	
    public function index()
    {
		$purchases = Purchase::all()-> sortByDesc('date');
		
		return view('purchases.index',compact('purchases')); 
    }    
	
    public function create()
    {
		$today = date('Y-m-d');
		$items = Item::all() -> sortBy('name');
		$godowns = Godown::all(); 
		return view('purchases.create',compact('godowns','items','today')); 
    }
	
    public function store(PurchaseFormRequest $request)
    {
		$purchase = new Purchase(array(
			'date' => date('Y-m-d',strtotime($request->get('date'))),
			'item_id' => $request->get('item'),			
			'qty' => $request->get('qty'),
			'number' => $request->get('number'),
			'slip_number' => $request->get('slip_number'),
			'lorry' => $request->get('lorry'),
			'godown_id' => $request->get('godown'),			
			'user_id' => Auth::user() -> id
        ));

		DB::beginTransaction();

		try{
			$purchase->save();	
		}
		catch(\Exception $e){
			DB::rollback();
			if (strpos($e->getMessage(), 'Duplicate entry') !== false)
				return redirect()-> back() ->with('error', 'Error!!! Duplicate delivery/slip number found for another purchase') -> withInput();							
			else
				return redirect()-> back() ->with('error', 'Error!!! Please contact admin with this message : '.$e->getMessage()) -> withInput();								
		}
		
		try{
			$stockError = $this -> addStock($purchase->date,$purchase->godown_id,$purchase->item_id,$purchase->qty);
		}
		catch(\Exception $e){
			DB::rollback();
			return redirect()-> back() ->with('error', 'Error!!! Please contact admin with this message : '.$e->getMessage()) -> withInput();								
		}			
		
		if($stockError == null)
			DB::commit();		

		return redirect()-> back() ->with('success', 'Purchase has been succesfully created!');
	}
}