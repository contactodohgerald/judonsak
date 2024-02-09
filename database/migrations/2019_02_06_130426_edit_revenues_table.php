<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->dropColumn('contract_nature');
            $table->dropColumn('amount');

            $table->string('description');
            $table->integer('budget_id');
            $table->integer('currency_id');
            $table->integer('category_id');//revenue or recievable
            $table->integer('payment_id');
            $table->date('issue_date');
            $table->decimal('total', 20, 2);
            $table->string('remark')->nullable();//reason why you rejected the budget
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
