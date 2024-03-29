<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaskNameAndInstructionNameToTaskPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_points', function (Blueprint $table) {
            $table->string('task_name')->nullable();
            $table->string('instruction_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_points', function (Blueprint $table) {
            $table->dropColumn(['task_name', 'instruction_name']);
        });
    }
}
