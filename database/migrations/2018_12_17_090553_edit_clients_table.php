<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditClientsTable extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('rcn')->nullable();
        });
    }

    public function down()
    {
        // Schema::table('clients', function (Blueprint $table) {
        //     $table->dropColumn('rcn');
        // });
    }
}
