<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecievablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recievables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feenote_id');
            $table->integer('currency_id');
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->date('balance_date')->nullable();
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
        Schema::dropIfExists('recievables');
    }
}
