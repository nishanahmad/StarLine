<?php 

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use App\Stock;

trait StockUpdates
{
    public function addStock($date,$godown,$item,$qty)
    {
		$error = null;
		$stock = Stock::where('date',$date)
				 ->where('godown_id',$godown)
				 ->where('item_id',$item)
				 -> get();
		if($stock->count() <= 0)
		{
			DB::beginTransaction();
			try{
				$prev_stock = DB::table('stocks')->where('date','<',$date)
										  ->where('godown_id',$godown)
										  ->where('item_id',$item)
										  ->orderBy('date','DESC')
										  ->limit(1)
										  ->get();
				if($prev_stock -> count() >0)
					$prev_qty = $prev_stock[0] -> closing;
				else
					$prev_qty = 0;
				
		
				DB::table('stocks')->insert([
					 'date' => $date, 'godown_id' => $godown, 'item_id' => $item, 
					 'closing' => $prev_qty
					]);		
			}
			catch(\Exception $e){
				DB::rollback();
				$error = $e -> getMessage();
			}

		}
		if($error == null)
		{
			try{
				$stocks = Stock::where('date','>=',$date)
						  -> where('godown_id',$godown)
						  -> where('item_id', $item);

				$stocks -> increment('closing', $qty);
					
			}
			catch(\Exception $e){
				DB::rollback();
				$error = $e -> getMessage();
			}
		}
		if($error == null)
			DB::commit();
		
		return $error;
    }    	
}