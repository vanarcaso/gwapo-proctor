<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Always send the homepage to the actual tasks page
Route::redirect('/', '/tasks');

Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
    ->name('tasks.status');

Route::resource('tasks', TaskController::class)->except(['show']);
