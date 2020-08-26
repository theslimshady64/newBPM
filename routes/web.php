<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {
        return view('index')->with('title', 'Главная');
    });

    Route::prefix('pmo')->group(function () {
        Route::prefix('fileStorage')->group(function () {
            Route::get('/', 'FileStorageController@index')->name('fileStorageIndex');
            Route::get('/{folder}', 'FileStorageController@show')->name('fileStorageShow');
            Route::post('/load', 'FileStorageController@load')->name('fileStorageLoad');
            Route::any('/download/{path}', 'FileStorageController@download')->name('fileStorageDownload');
            Route::post('createFolder', 'FileStorageController@createFolder')->name('createFolder');
            Route::post('editFolder', 'FileStorageController@editFolder')->name('editFolder');
            Route::post('editFile', 'FileStorageController@editFile')->name('editFile');
            Route::get('deleteFile/{path}', 'FileStorageController@deleteFile')->name('deleteFile');
            Route::get('deleteFolder/{path}', 'FileStorageController@deleteFolder')->name('deleteFolder');
        });

        Route::prefix('budget')->group(function () {
            Route::get('/', 'Test@budget')->name('budget');
        });

        Route::prefix('project')->group(function () {
            Route::get('/', 'Test@project')->name('project');
        });

        Route::prefix('contract')->group(function () {
            Route::get('/', 'Test@contract')->name('contract');
        });

        Route::prefix('library')->group(function () {
            Route::get('/', 'Test@library')->name('library');
        });

        Route::prefix('maintenance')->group(function () {
            Route::get('/', 'Test@maintenance')->name('maintenance');
        });

        Route::prefix('scenario')->group(function () {
            Route::get('/', 'Test@scenario')->name('scenario');
        });

        Route::prefix('report')->group(function () {
            Route::get('/', 'Test@report')->name('report');
        });

        Route::prefix('document')->group(function () {
            Route::get('/', 'Test@document')->name('document');
        });

        Route::prefix('integration')->group(function () {
            Route::get('/', 'Test@integration')->name('integration');
        });
    });
});
