<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepatamentosIdToRelacionamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relacionamentos', function (Blueprint $table) {
            $table -> foreignId('departamentos_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relacionamentos', function (Blueprint $table) {
            $table -> foreignId('departamentos_id')->constrained()->onDelete('cascade');
        });
    }
}
