<?php

use App\Http\Controllers\GetUserByNameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\CheckAdminRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard',[TaskController::class,'index'] )->name('dashboard');
    Route::group(['middleware' => ['admin_role']],function (){
        Route::get('/tasks/create', [TaskController::class,'create'])->name('tasks.create');
        Route::post('/tasks/store', [TaskController::class,'store'])->name('tasks.store');;
        Route::get('/statistics', StatisticsController::class)->name('statistics');
        Route::get('/search', GetUserByNameController::class)->name('search');

    });
});

require __DIR__.'/auth.php';
