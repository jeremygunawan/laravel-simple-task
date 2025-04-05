<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProjectController;
use App\Http\Controllers\Web\TaskController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => '/projects', 'middleware' => ['auth']], function() {
	Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
	Route::get('/create', [ProjectController::class, 'create']);
	Route::post('/create', [ProjectController::class, 'store']);

	Route::get('/edit/{id}', [ProjectController::class, 'edit']);
	Route::post('/edit/{id}', [ProjectController::class, 'update']);

	Route::post('/delete', [ProjectController::class, 'delete']);
});

Route::group(['prefix' => '/tasks', 'middleware' => ['auth']], function() {
	Route::get('/', [TaskController::class, 'index'])->name('projects.index');
	
	Route::post('/create', [TaskController::class, 'store']);

	Route::get('/load/{id}', [TaskController::class, 'load']);
	Route::post('/edit/{id}', [TaskController::class, 'update']);

	Route::post('/delete', [TaskController::class, 'delete']);
});