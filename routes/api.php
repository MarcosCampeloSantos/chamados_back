<?php

use App\Http\Controllers\AdmController;
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

// Methods Get
Route::get('/buscar_users', [UsuarioController::class, 'BuscarUsers'])->name('BuscarUsers'); #Busca Todos os Usuarios
Route::get('/buscar_dep', [AdmController::class, 'BuscarDep'])->name('BuscarDep'); #Busca Todos os Departamentos
Route::get('/buscar_top', [AdmController::class, 'BuscarTop'])->name('BuscarTop'); #Busca Todos os Topicos
Route::get('/buscar_rel', [AdmController::class, 'BuscarRel'])->name('BuscarRel'); #Busca Todos os Relacionamentos

// Methods Post
Route::post('/criar_user', [UsuarioController::class, 'StoreUsuario'])->name('CriarUsuario'); #Cria novo Usuario
Route::post('/criar_dep', [AdmController::class, 'StoreDepartamento'])->name('CriarDep'); #Cria novo Departamento
Route::post('/criar_top', [AdmController::class, 'StoreTopicos'])->name('CriarTop'); #Cria novo Topico
Route::post('/criar_rel', [AdmController::class, 'StoreRelaciomento'])->name('CriarRel'); #Cria novo Relacionamento
Route::post('/editar_rel', [AdmController::class, 'EditarRel'])->name('EditarRel'); #Edita um relacionamento
Route::post('/adc_atribuido', [AdmController::class, 'AdcAtributo'])->name('AdcAtributo'); #Edita usuarios atribuidos ao relacionamento

//Methods Delete
Route::delete('/trash_atribuido', [AdmController::class, 'ExcluirAtributo'])->name('ExcluirAtributo'); #Excluir usuarios atribuidos ao relacionamento
Route::delete('/trash_relacionamento', [AdmController::class, 'ExcluirRel'])->name('ExcluirRel'); #Excluir relacionamentos
Route::delete('/trash_departamento', [AdmController::class, 'ExcluirDep'])->name('ExcluirDep'); #Excluir Departamento