<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProjectController;

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