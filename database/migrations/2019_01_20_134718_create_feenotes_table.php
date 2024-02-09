<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeenotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feenotes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->integer('user_id');
            $table->integer('client_id');
            $table->integer('payment_id');
            $table->integer('amount');
            $table->integer('vat');
            $table->integer('payable');
            $table->integer('bank_id');
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
        Schema::dropIfExists('feenotes');
    }
}
