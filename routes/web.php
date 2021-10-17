<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;

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
Route::get('/employee', [EmployeeController::class, 'home']);
Route::post('/employee', [EmployeeController::class, 'create']);
Route::post('/user', [UserController::class, 'create']);
Route::get('/user/{id}', [UserController::class, 'verify']);
