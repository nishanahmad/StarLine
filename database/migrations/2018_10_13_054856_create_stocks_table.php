<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
			$table->date('date');
			$table->tinyInteger('item_id')->unsigned();
			$table->tinyInteger('godown_id')->unsigned();
			$table->mediumInteger('closing')->unsigned();
			$table->unique(['date', 'item_id', 'godown_id']);			
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
