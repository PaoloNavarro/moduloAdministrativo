<?php

use App\Http\Controllers\UserApiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Ruta para listar usuarios

// Ruta para mostrar el formulario de creación de usuario
Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('role:admin');
Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware('role:admin');
Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('role:admin');
Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit')->middleware('role:admin');
Route::put('users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('role:admin');

