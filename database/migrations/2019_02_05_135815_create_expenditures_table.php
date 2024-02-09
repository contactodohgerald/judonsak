<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpendituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenditures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('budget_id');
            $table->integer('expenditure_category_id');
            $table->decimal('gross', 20, 2)->nullable();
            $table->decimal('employer_cost', 20, 2)->nullable();
            $table->decimal('total', 20, 2);
            $table->integer('status_id')->default(4);
            $table->string('remark')->nullable();//reason why you rejected the budget
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
        Schema::dropIfExists('expenditures');
    }
}
