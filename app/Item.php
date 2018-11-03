<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id'];
	
	public function orders()
	{
		return $this->hasMany('App\Order')->get();
	}	
}
