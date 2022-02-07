<?php

use App\Http\Controllers\AdmController;
use App\Http\Controllers\AtribuicaoController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\EstadosController;
use App\Http\Controllers\InteracoesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopicoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [LoginController::class, 'Login'])->name('Login'); #Logar
Route::post('/logout', [LoginController::class, 'Logout'])->name('Logout'); #Logout
Route::post('/verificacao', [LoginController::class, 'Verificacao'])->name('Verificacao'); #Verificacao


Route::middleware(['auth:sanctum'])->group(function () {

    // Methods Get
    Route::get('/buscar_users', [UsuarioController::class, 'BuscarUsers'])->name('BuscarUsers'); #Busca Todos os Usuarios
    Route::get('/buscar_dep', [AdmController::class, 'BuscarDep'])->name('BuscarDep'); #Busca Todos os Departamentos
    Route::get('/buscar_top', [AdmController::class, 'BuscarTop'])->name('BuscarTop'); #Busca Todos os Topicos
    Route::get('/buscar_rel', [AdmController::class, 'BuscarRel'])->name('BuscarRel'); #Busca Todos os Relacionamentos

    // Methods Resource
    Route::resource('/chamado', ChamadoController::class); #Chamado
    Route::resource('/interacoes', InteracoesController::class); #Interacoes do Chamado
    Route::resource('/estados', EstadosController::class);
    Route::resource('/atribuicao', AtribuicaoController::class); #Atribuicoes
    Route::resource('/topico', TopicoController::class); #Topicos
    
    Route::post('/modo_operador', [UsuarioController::class, 'ModoOperador'])->name('ModoOperador');
    Route::post('/criar_user', [UsuarioController::class, 'StoreUsuario'])->name('CriarUsuario'); #Cria novo Usuario
    Route::post('/criar_dep', [AdmController::class, 'StoreDepartamento'])->name('CriarDep'); #Cria novo Departamento
    Route::post('/criar_top', [AdmController::class, 'StoreTopicos'])->name('CriarTop'); #Cria novo Topico
    
});

