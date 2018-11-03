<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
			$table->Integer('order_id')->unsigned();
			$table->date('date');
			$table->mediumInteger('qty')->unsigned();			
			$table->bigInteger('number')->unsigned() -> unique();	
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
        Schema::dropIfExists('invoices');
    }
}
