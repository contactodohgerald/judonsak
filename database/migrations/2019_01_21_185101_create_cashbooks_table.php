<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('bank_id');
            $table->integer('currency_id');//different currencies
            $table->integer('category_id');//CorperatOrClient--RevenueOrClient
            $table->integer('group_id');//Debit==1--Credit=2
            $table->integer('cashbook_label_id');
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('description');
            $table->date('date');
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
        Schema::dropIfExists('cashbooks');
    }
}
