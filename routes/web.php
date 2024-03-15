<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\ContabilidadController;
use App\Http\Controllers\CitaguardadaController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\ShowDateController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactoController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
Route::get('/reset-password', [ResetPasswordController::class, 'show']);
Route::post('/register/entidades', [RegisterController::class, 'entidad']);


Auth::routes();
// Rutas autenticadas
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    
    /* Entidades */
    Route::get('/home', [EntidadController::class, 'index']);
    Route::post('/ver-agenda', [EntidadController::class, 'show']);
    // web.php o api.php
    Route::get('/home/consulta/{cedula}', [EntidadController::class, 'consult']);

    Route::post('/home/consulta/horario', [EntidadController::class, 'horario']);

    // envío de datos para guardar la cita
    Route::post('/home/consulta/horario/guardarcita', [CitaguardadaController::class, 'guardar']);

    // actualizar datos
    Route::get('/update', [UpdateController::class, 'update']);
    Route::post('/update/existing', [UpdateController::class, 'updateexisting']);
    Route::post('/update/datos', [UpdateController::class, 'create']);
    Route::post('/update/miembros', [UpdateController::class, 'miembros']);
    Route::post('/update/validarmiembros', [UpdateController::class, 'validarmiembro']);
        


    // ver las citas programadas
    Route::get('/show/date', [ShowDateController::class, 'showDate']);
    Route::post('/show/date/canceldate', [ShowDateController::class, 'canceldate']);

    //las entidades que tengan activas con el regimen
    Route::post('/entidades/activas', [UpdateController::class, 'entidad']);
    Route::post('/entidades/codigoentidad', [UpdateController::class, 'codigoentidad']);

    //contacto para whatsapp
    Route::get('/contacto', [ContactoController::class, 'store']);
    
});