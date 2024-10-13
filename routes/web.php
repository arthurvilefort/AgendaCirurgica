<?php

use App\Http\Controllers\HospitalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Auth::routes();
Route::group(['middleware' => 'auth'], function() {

Route::get('/', [App\Http\Controllers\HospitalController::class, 'index'])->name('hospitais');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('usuarios');

Route::get('/{user}/destroy/user', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');

Route::put('/{user}/update/user', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

Route::get('/hospitais', [App\Http\Controllers\HospitalController::class, 'index'])->name('hospitais');

Route::post('/createhospital', [App\Http\Controllers\HospitalController::class, 'store'])->name('createhospital');

Route::get('/{hospital}/destroy/hospital', [App\Http\Controllers\HospitalController::class, 'destroy'])->name('hospital.destroy');

Route::put('/{hospital}/update/hospital', [App\Http\Controllers\HospitalController::class, 'update'])->name('hospital.update');

Route::post('/hospital/{hospital}/add-user', [HospitalController::class, 'addUser'])->name('hospital.addUser');

Route::delete('/hospital/{hospital}/remove-user/{user}', [HospitalController::class, 'removeUser'])->name('hospital.removeUser');

Route::get('/{id}/sala', [App\Http\Controllers\RoomController::class, 'index'])->name('sala.exibir');

Route::post('/createsala', [App\Http\Controllers\RoomController::class, 'store'])->name('createsala');

Route::get('/{sala}/destroy/sala', [App\Http\Controllers\RoomController::class, 'destroy'])->name('sala.destroy');

Route::put('/{sala}/update/sala', [App\Http\Controllers\RoomController::class, 'update'])->name('sala.update');

Route::get('/procedimentos', [App\Http\Controllers\Surgery_typesController::class, 'index'])->name('procedimentos');

Route::post('/createprocedimento', [App\Http\Controllers\Surgery_typesController::class, 'store'])->name('createprocedimento');

Route::get('/{procedimento}/destroy/procedimento', [App\Http\Controllers\Surgery_typesController::class, 'destroy'])->name('procedimento.destroy');

Route::put('/{procedimento}/update/procedimento', [App\Http\Controllers\Surgery_typesController::class, 'update'])->name('procedimento.update');

Route::post('/sala/{sala}/addRestrictions', [App\Http\Controllers\RoomController::class, 'addRestrictions'])->name('sala.addRestrictions');

Route::delete('/sala/{sala}/removeRestrictions/{tipocirurgia}', [App\Http\Controllers\RoomController::class, 'removeRestrictions'])->name('sala.removeRestrictions');

Route::get('/pacientes', [App\Http\Controllers\PacientsController::class, 'index'])->name('pacientes');

Route::post('/createpacientes', [App\Http\Controllers\PacientsController::class, 'store'])->name('createpacientes');

Route::get('/{pacient}/destroy/pacientes', [App\Http\Controllers\PacientsController::class, 'destroy'])->name('pacients.destroy');

Route::put('/{pacient}/update/pacient', [App\Http\Controllers\PacientsController::class, 'update'])->name('pacients.update');

Route::get('/agendamento', [App\Http\Controllers\SurgeriesController::class, 'index'])->name('agendamento');

Route::post('/agendamento', [App\Http\Controllers\SurgeriesController::class, 'store'])->name('agendamento.store');

Route::get('/api/hospitals/{hospital}/salas', [App\Http\Controllers\SurgeriesController::class, 'getSalas']);

Route::get('/get-tipos-cirurgia/{sala}', [App\Http\Controllers\SurgeriesController::class, 'getTiposCirurgia'])->name('getTiposCirurgia');
});