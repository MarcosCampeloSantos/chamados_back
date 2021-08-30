<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempos', function (Blueprint $table) {
            $table->id();
            $table->string('chamado_id');
            $table->string('inicio')->nullable($value = true);
            $table->string('termino')->nullable($value = true);
            $table->string('tempototal')->nullable($value = true);
            $table->string('finalizado')->nullable($value = true);
            $table->string('tempototal_id')->nullable($value = true);
            $table->string('pausado')->nullable($value = true);
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
        Schema::dropIfExists('tempos');
    }
}
