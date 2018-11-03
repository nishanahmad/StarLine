<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferLog extends Model
{
	protected $guarded = ['id'];
	
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
