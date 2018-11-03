<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_logs', function (Blueprint $table) {
            $table->increments('id');
			$table->date('date');		
			$table->tinyInteger('item_id')->unsigned();
			$table->Integer('qty')->unsigned();						
			$table->smallInteger('from')->unsigned();
			$table->smallInteger('to')->unsigned();
			$table->string('remarks',255)-> nullable();
			$table->smallInteger('user_id')->unsigned();
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
        Schema::dropIfExists('transfer_logs');
    }
}
