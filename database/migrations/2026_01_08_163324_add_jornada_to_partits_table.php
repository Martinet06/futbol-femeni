<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('partits', function (Blueprint $table) {
            $table->unsignedInteger('jornada')->nullable(); // o integer, según tu lógica
        });
    }

    public function down()
    {
        Schema::table('partits', function (Blueprint $table) {
            $table->dropColumn('jornada');
        });
    }
};
