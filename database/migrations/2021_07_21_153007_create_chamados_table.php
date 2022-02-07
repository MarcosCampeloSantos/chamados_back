<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('departamento');
            $table->string('estado');
            $table->timestamps();
        });

        $usuario = new User();
        $usuario->name = 'Administrador';
        $usuario->departamento = 'Tecnologia da Informação';
        $usuario->email = 'adm@chamados.com.br';
        $usuario->password = Hash::make('123456');
        $usuario->nivel = '1';

        $usuario->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chamados');
    }
}
