<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes(['login' => false]);

Route::middleware('guest')->group(function (){
});
    Route::get('/api/auth/check', [LoginController::class, 'checkUserLogin'])->name('auth.check');
    Route::post('/api/auth/login', [LoginController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function () {
    Route::get('/api/dashboard', [App\Http\Controllers\HomeController::class, 'showDashboard'])->name('home');

    // Subject
    Route::apiResource('api/subject', SubjectController::class);

    // Task
    Route::patch('api/task/{task}/complete', [TaskController::class, 'complete'])->name('task.complete');
    Route::get('api/task/{task}/delete', [TaskController::class, 'delete'])->name('task.delete');
    Route::apiResource('api/task', TaskController::class);

    // Material
    Route::get('api/material/{material}/delete', [MaterialController::class, 'delete'])->name('material.delete');
    Route::get('api/material/trash', [MaterialController::class, 'trash'])->name('material.trash');
    Route::get('api/material/trash/empty', [MaterialController::class, 'emptyTrash'])->name('material.emptyTrash');
    Route::get('api/material/list/{subject_id}', [MaterialController::class, 'listBySubject'])->name('material.list');
    Route::post('api/material/{material}/restore', [MaterialController::class, 'restore'])->name('material.restore');
    Route::delete('api/material/{material}/softDelete', [MaterialController::class, 'softDelete'])->name('material.softDelete');
    Route::apiResource('api/material', MaterialController::class);

    // Category
    Route::resource('category', CategoryController::class);

    // Schedule
    Route::post('schedule/{schedule}', [ScheduleController::class, 'toggleActive'])->name('schedule.active');
    Route::apiResource('api/schedule', ScheduleController::class);

    // Lectures
    Route::post('api/lecture/{schedule_id}', [LectureController::class, 'store'])->name('lecture.store');
    Route::apiResource('api/lecture', LectureController::class)->except('store');
});

Route::view('/{any}', 'layouts.app')->where('any', '.*');
