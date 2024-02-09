<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedInteger('executor_id')->nullable()->default(null);
            $table->unsignedInteger('line_manager_id')->nullable()->default(null);

            $table->foreign('executor_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('line_manager_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('executor_id');
            $table->dropColumn('line_manager_id');
        });
    }
}
