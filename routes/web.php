<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('usuarios');

Route::get('/{user}/destroy/user', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');

Route::put('/{user}/update/user', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

Route::get('/hospitais', [App\Http\Controllers\HospitalController::class, 'index'])->name('hospitais');

Route::post('/createhospital', [App\Http\Controllers\HospitalController::class, 'store'])->name('createhospital');

Route::get('/{hospital}/destroy/hospital', [App\Http\Controllers\HospitalController::class, 'destroy'])->name('hospital.destroy');

Route::put('/{hospital}/update/hospital', [App\Http\Controllers\HospitalController::class, 'update'])->name('hospital.update');
