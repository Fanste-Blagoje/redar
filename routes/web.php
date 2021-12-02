<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\HousesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\ReplacementsController;


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

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/replacement', [App\Http\Controllers\HomeController::class, 'replacement'])->name('home.replacement');



Route::middleware('auth')->prefix('/admin')->namespace('Admin')->group(function () {

    Route::get('/', [IndexController::class, 'index'])->name('admin.index.index');

    //Routes for HousesController
    Route::prefix('/houses')->group(function () {

        Route::get('/', [HousesController::class, 'index'])->name('admin.houses.index');

        Route::get('/add', [HousesController::class, 'add'])->name('admin.houses.add');
        Route::post('/insert', [HousesController::class, 'insert'])->name('admin.houses.insert');

        Route::get('/edit/{house}', [HousesController::class, 'edit'])->name('admin.houses.edit');
        Route::post('/update/{house}', [HousesController::class, 'update'])->name('admin.houses.update');

        Route::post('/delete', [HousesController::class, 'delete'])->name('admin.houses.delete');

        Route::post('/datatable', [HousesController::class, 'datatable'])->name('admin.houses.datatable');
    });

    //Routes for UsersController
    Route::prefix('/users')->group(function () {

        Route::get('/', [UsersController::class, 'index'])->name('admin.users.index');

        Route::get('/add', [UsersController::class, 'add'])->name('admin.users.add');
        Route::post('/insert', [UsersController::class, 'insert'])->name('admin.users.insert');

        Route::get('/edit/{user}', [UsersController::class, 'edit'])->name('admin.users.edit');
        Route::post('/update/{user}', [UsersController::class, 'update'])->name('admin.users.update');

        Route::post('/delete', [UsersController::class, 'delete'])->name('admin.users.delete');

        Route::post('/disable', [UsersController::class, 'disable'])->name('admin.users.disable');
        Route::post('/enable', [UsersController::class, 'enable'])->name('admin.users.enable');

        Route::post('/datatable', [UsersController::class, 'datatable'])->name('admin.users.datatable');
    });

    //Routes for ScheduleController
    Route::prefix('/schedule')->group(function () {

        Route::get('/', [ScheduleController::class, 'index'])->name('admin.schedule.index');

        Route::get('/add', [ScheduleController::class, 'add'])->name('admin.schedule.add');
        Route::post('/insert', [ScheduleController::class, 'insert'])->name('admin.schedule.insert');

        Route::get('/edit/{schedule}', [ScheduleController::class, 'edit'])->name('admin.schedule.edit');
        Route::post('/update/{schedule}', [ScheduleController::class, 'update'])->name('admin.schedule.update');

        Route::post('/delete', [ScheduleController::class, 'delete'])->name('admin.schedule.delete');

        Route::post('/datatable', [ScheduleController::class, 'datatable'])->name('admin.schedule.datatable');
        
        Route::get('/get-user/{house}', [ScheduleController::class, 'getUser'])->name('admin.schedule.get_user');
    });
    //Routes for ReplacementsController
    Route::prefix('/replacements')->group(function () {

        Route::get('/', [ReplacementsController::class, 'index'])->name('admin.replacements.index');

        Route::post('/datatable', [ReplacementsController::class, 'datatable'])->name('admin.replacements.datatable');
    });
});



\PWA::routes();
