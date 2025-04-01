<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LogViewerController;
use App\Http\Controllers\TreeViewController;
use App\Http\Controllers\RouteListController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\EnvController;
use App\Http\Controllers\LandingPageController;

Route::name('landing.')->group(function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('index');
    Route::get('/rules', [LandingPageController::class, 'rules'])->name('rules');
    Route::get('/store', [LandingPageController::class, 'store'])->name('store');
    Route::group(['prefix' => 'checkout', 'as' => 'checkout.'], function () {
        Route::get('{item}', [LandingPageController::class, 'checkout'])->name('index');
        Route::post('{item}', [LandingPageController::class, 'checkoutStore'])->name('store');
        Route::post('gift/{item}', [LandingPageController::class, 'checkoutGift'])->name('gift');
    });
    Route::get('/staff', [LandingPageController::class, 'staff'])->name('staff');
});

Route::group(['middleware' => ['auth']], function () {
    // GENERAL
    Route::get('/home', [MainController::class, 'index'])->name('home');
    Route::get('/profile', [MainController::class, 'profile'])->name('profile');
    Route::get('/settings', [MainController::class, 'settings'])->name('settings');

    Route::group(['middleware' => ['permission']], function () {

        // LOGVIEWER
        Route::prefix('logviewer')->name('logviewer.')->group(function () {
            Route::get('/', [LogViewerController::class, 'index'])->name('index');
            Route::get('/show/{filename}', [LogViewerController::class, 'show'])->name('show');
            Route::delete('/delete/{filename}', [LogViewerController::class, 'destroy'])->name('destroy');
            Route::get('/download/{filename}', [LogViewerController::class, 'download'])->name('download');
        });
        // FOLDER TREE
        Route::prefix('foldertree')->name('foldertree.')->middleware(['auth'])->group(function () {
            Route::get('/', [TreeViewController::class, 'index'])->name('index');
        });
        // ROUTELIST
        Route::prefix('routelist')->name('routelist.')->group(function () {
            Route::get('/', [RouteListController::class, 'index'])->name('index');
        });
        // PERFORMANCE
        Route::prefix('performance')->name('performance.')->group(function () {
            Route::get('/', [PerformanceController::class, 'index'])->name('index');
        });
        // DATABASE
        Route::prefix('database')->name('database.')->group(function () {
            Route::get('/', [DatabaseController::class, 'index'])->name('index');
            Route::get('/database', [DatabaseController::class, 'indexDatabase'])->name('index-database');
            Route::get('/indexsql', [DatabaseController::class, 'indexSql'])->name('index-sql');
            Route::post('/sql', [DatabaseController::class, 'sql'])->name('sql');
            Route::get('/show/{tableName}', [DatabaseController::class, 'showTable'])->name('show');
            Route::post('/store/{tableName}', [DatabaseController::class, 'store'])->name('store');
            Route::put('/update/{tableName}/{id}', [DatabaseController::class, 'update'])->name('update');
            Route::delete('/destroy/{tableName}/{id}', [DatabaseController::class, 'destroy'])->name('destroy');
            Route::delete('/empty/{tableName}', [DatabaseController::class, 'empty'])->name('empty');
        });
        // ENV
        Route::prefix('env')->name('env.')->group(function () {
            Route::get('/', [EnvController::class, 'index'])->name('index');
            Route::put('update', [EnvController::class, 'update'])->name('update');
        });
    });
});
