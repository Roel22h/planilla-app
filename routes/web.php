<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\CicloEscolarController;
use App\Http\Controllers\RegiPlanillaController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/index', [IndexController::class, 'index']);

// LOGIN
Route::get('/signin', [SigninController::class, 'signin']);
Route::post('/login', [SigninController::class, 'login']);
Route::get('/logout', [SigninController::class, 'logout']);

// USUARIOS
Route::get('/usuario-lista', [UsuarioController::class, 'lista']);
Route::post('/usuario-agregar', [UsuarioController::class, 'agregar']);
Route::post('/usuario-buscar', [UsuarioController::class, 'buscar']);
Route::post('/usuario-editar', [UsuarioController::class, 'editar']);

// ROLES
Route::get('/rol-lista', [RolController::class, 'lista']);
Route::post('/rol-agregar', [RolController::class, 'agregar']);
Route::post('/rol-buscar', [RolController::class, 'buscar']);
Route::post('/rol-editar', [RolController::class, 'editar']);

// INSTITUCIONES
Route::get('/institucion-lista', [InstitucionController::class, 'lista']);
Route::post('/institucion-agregar', [InstitucionController::class, 'agregar']);
Route::post('/institucion-buscar', [InstitucionController::class, 'buscar']);
Route::post('/institucion-editar', [InstitucionController::class, 'editar']);

// DOCENTES
Route::get('/docente-lista', [DocenteController::class, 'lista']);
Route::post('/docente-agregar', [DocenteController::class, 'agregar']);
Route::post('/docente-buscar', [DocenteController::class, 'buscar']);
Route::post('/docente-editar', [DocenteController::class, 'editar']);


// CICLO ESCOLAR
Route::get('/ciclo-agregar', [CicloEscolarController::class, 'agregar']);
Route::post('/ciclo-insertar', [CicloEscolarController::class, 'insertar']);
Route::get('/ciclo-lista', [CicloEscolarController::class, 'lista']);
Route::post('/ciclo-finalizar', [CicloEscolarController::class, 'finalizar']);

// CICLO ESCOLAR
Route::get('/planilla-agregar', [RegiPlanillaController::class, 'agregar']);
Route::post('/planilla-insertar', [RegiPlanillaController::class, 'insertar']);
Route::get('/planilla-lista', [RegiPlanillaController::class, 'lista']);

Route::get('/storage/{ruta}', function ($ruta) {
    return response()->download(storage_path('app/' . $ruta));
})->where('ruta', '.*');

Route::redirect('/', '/signin');


// REPORTES
Route::get('/reporte-docentes', [ReporteController::class, 'docente']);
Route::post('/reporte-getdocentes', [ReporteController::class, 'docentelista']);

Route::get('/reporte-instituciones', [ReporteController::class, 'institucion']);
Route::post('/reporte-getinstituciones', [ReporteController::class, 'institucionlista']);
