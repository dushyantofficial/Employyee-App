<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::resource('/', App\Http\Controllers\EmployeeController::class);

Route::get('get_employee', [\App\Http\Controllers\EmployeeController::class, 'get_employee'])->name('get-employee');
Route::get('edit/{id}', [\App\Http\Controllers\EmployeeController::class, 'edit'])->name('employee-edit');
Route::post('update/{id}', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('employee-update');
Route::get('delete_employee/{id}', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->name('delete-employee');
