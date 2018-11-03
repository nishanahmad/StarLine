<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
			$table->date('date');
			$table->tinyInteger('item_id')->unsigned();
			$table->mediumInteger('qty')->unsigned();
			$table->smallInteger('client_id')->unsigned();
			$table->string('status',15)->->default('Pending');
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
        Schema::dropIfExists('orders');
    }
}
