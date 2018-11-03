<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
			$table->date('date');		
			$table->smallInteger('item_id')->unsigned();
			$table->mediumInteger('qty')->unsigned();						
			$table->Integer('number')->unsigned() -> unique();	
			$table->Integer('slip_number')->unsigned() -> unique();	
			$table->string('lorry',30) -> nullable();
			$table->smallInteger('godown_id')->unsigned();
			$table->smallInteger('user_id')->unsigned();
			$table->smallInteger('updated_by')->unsigned() -> nullable();									
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
        Schema::dropIfExists('purchases');
    }
}
