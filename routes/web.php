<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;

Route::get('/', [EmployeeController::class, 'dashboard']);
Route::get('/dept/insert', [EmployeeController::class, 'insertValues']);
Route::post('/employee/excel/upload', [EmployeeController::class,'employeesImport'])->name('employee/excel/upload');
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

// Route::get('/department-insert', 'DepartmentController@insertValues');
// // Route::get('/', function () {
// //     return view('home');
// // });
// Route::any('/', 'EmployeeController@dashboard')->name('dashboard');