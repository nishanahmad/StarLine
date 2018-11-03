<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = ['id'];
	
	public function orders()
	{
		return $this->hasMany('App\Order')->get();
	}	
}
