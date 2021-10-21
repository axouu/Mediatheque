<?php

use App\Http\Controllers\BookController;
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
})->name('welcome');
Route::get('/login', [UserController::class, 'loginView'])->name('login');
Route::get('/books', [BookController::class, 'home'])->name('books');

Route::post('/register', [UserController::class, 'create']);
Route::post('/borrow/{id}', [UserController::class, 'borrow']);
Route::post('/login', [UserController::class, 'login']);
Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
    Route::get('/dashboard', [EmployeeController::class, 'home'])->name('dashboard');
    Route::get('/confirm', [EmployeeController::class, 'confirm']);
    Route::get('/books/add', [BookController::class, 'addForm']);

    Route::post('/register', [EmployeeController::class, 'create']);
    Route::post('/login', [EmployeeController::class, 'login']);
    Route::post('/books/add', [BookController::class, 'add']);
    Route::post('/verify/{id}', [EmployeeController::class, 'verify']);
    Route::post('/confirm/{id}', [EmployeeController::class, 'confirmBorrow']);
    Route::post('/restore', [EmployeeController::class, 'restore']);
});

Route::delete('/logout', [UserController::class, 'logout']);
