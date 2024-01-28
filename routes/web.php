<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckLogin;
use App\Models\Admin;
use App\Models\Salary;
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
Route::get('login', [LoginController::class, 'get']);
Route::post('login', [LoginController::class, 'post']);
Route::middleware([CheckLogin::class])->group(function() {
	Route::get('/', [IndexController::class, 'index']);
	Route::get('index', [IndexController::class, 'index']);
	Route::get('out', [LoginController::class, 'out']);
	Route::get('user/index', [LoginController::class, 'out']);
    //后台用户管理
	Route::prefix('admin')->group(function() {
		Route::get('index', [AdminController::class, 'index']);
		Route::get('list', [AdminController::class, 'list']);
		Route::get('add', [AdminController::class, 'add']);
		Route::post('add', [AdminController::class, 'addPost']);
		Route::get('del/{id}', [AdminController::class, 'del']);
		Route::get('edit/{id}', [AdminController::class, 'edit']);
		Route::post('edit/{id}', [AdminController::class, 'editPost']);
	});
    //员工管理
	Route::prefix('user')->group(function() {
		Route::get('index', [UserController::class, 'index']);
		Route::get('list', [UserController::class, 'list']);
		Route::get('add', [UserController::class, 'add']);
		Route::post('add', [UserController::class, 'addPost']);
		Route::get('del/{id}', [UserController::class, 'del']);
		Route::get('edit/{id}', [UserController::class, 'edit']);
		Route::post('edit/{id}', [UserController::class, 'editPost']);
	});
    //工资发放
	Route::prefix('salary')->group(function() {
		Route::get('index', [SalaryController::class, 'index']);
		Route::get('list', [SalaryController::class, 'list']);
		Route::get('add', [SalaryController::class, 'add']);
		Route::post('add', [SalaryController::class, 'addPost']);
		Route::get('del/{id}', [SalaryController::class, 'del']);
		Route::get('edit/{id}', [SalaryController::class, 'edit']);
		Route::post('edit/{id}', [SalaryController::class, 'editPost']);
	});
});