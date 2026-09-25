<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'index'])->name('home');
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
Route::resource('tasks', TaskController::class)->except(['show']);
