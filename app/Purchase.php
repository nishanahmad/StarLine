<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = ['id'];
	
    public function item()
    {
        return $this->belongsTo('App\Item');
    }	
	
    public function godown()
    {
        return $this->belongsTo('App\Godown');
    }		
}
