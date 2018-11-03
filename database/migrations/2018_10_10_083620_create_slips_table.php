<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slips', function (Blueprint $table) {
            $table->increments('id');
			$table->Integer('order_id')->unsigned();
			$table->date('date');		
			$table->mediumInteger('qty')->unsigned();						
			$table->Integer('number')->unsigned() -> unique();	
			$table->smallInteger('godown_id')->unsigned();
			$table->string('lorry',30) -> nullable();
			$table->string('driver',30) -> nullable();
			$table->time('time') -> nullable();
			$table->string('remarks',255)-> nullable();
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
        Schema::dropIfExists('slips');
    }
}
