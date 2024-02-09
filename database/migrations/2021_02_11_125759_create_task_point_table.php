<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('partners_point')->nullable();
            $table->integer('line_manager_point')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('task_id')->nullable();
            $table->unsignedInteger('person_id')->nullable();
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_point');
    }
}
