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
Route::get('/buscar_users', [UsuarioController::class, 'BuscarUsers'])->name('BuscarUsers');
Route::get('/buscar_dep', [AdmController::class, 'BuscarDep'])->name('BuscarDep');
Route::get('/buscar_top', [AdmController::class, 'BuscarTop'])->name('BuscarTop');
Route::get('/buscar_rel', [AdmController::class, 'BuscarRel'])->name('BuscarRel');

// Methods Post
Route::post('/criar_user', [UsuarioController::class, 'StoreUsuario'])->name('CriarUsuario');
Route::post('/criar_dep', [AdmController::class, 'StoreDepartamento'])->name('CriarDep');
Route::post('/criar_top', [AdmController::class, 'StoreTopicos'])->name('CriarTop');
Route::post('/criar_rel', [AdmController::class, 'StoreRelaciomento'])->name('CriarRel');