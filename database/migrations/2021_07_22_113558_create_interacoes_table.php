<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteracoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chamado_id');
            $table->unsignedBigInteger('user_id');
            $table->string('chat');
            $table->foreign('chamado_id')->references('id')->on('chamados');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('interacoes');
    }
}
