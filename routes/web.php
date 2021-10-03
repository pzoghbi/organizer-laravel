<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

    // Subject
    Route::resource('subject', SubjectController::class)->except('show');

    // Task
    Route::patch('/task/{task}/complete', [TaskController::class, 'complete'])->name('task.complete');
    Route::get('/task/{task}/delete', [TaskController::class, 'delete'])->name('task.delete');
    Route::resource('task', TaskController::class);

    // Material
    Route::get('/material/{material}/delete', [MaterialController::class, 'delete'])->name('material.delete');
    Route::get('/material/subject/{subject_id}', [MaterialController::class, 'subject'])->name('material.subject');
    Route::resource('material', MaterialController::class);

    // Category
    Route::resource('category', CategoryController::class);

    // Schedule
    Route::resource('schedule', ScheduleController::class);

    // Lectures
    Route::post('lecture/{schedule_id}', [LectureController::class, 'store'])->name('lecture.store');
    Route::resource('lecture', LectureController::class)->except('store');
});

