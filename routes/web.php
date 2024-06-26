<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    // Home
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Email Formatter
    Route::get('/email-formatter', [App\Http\Controllers\UserCredentialController::class, 'index'])->name('email-formatter');
    Route::post('/upload', [App\Http\Controllers\UserCredentialController::class, 'storeFromFile'])->name('upload');
    Route::get('/file', [App\Http\Controllers\UserCredentialController::class, 'file'])->name('file');
    Route::get('/export', [App\Http\Controllers\UserCredentialController::class, 'export'])->name('export');
    Route::delete('/delete', [App\Http\Controllers\UserCredentialController::class, 'delete'])->name('delete');

    // Randoms
    Route::get('/randoms', [App\Http\Controllers\RandomNameSurnameController::class, 'index'])->name('randoms');
    Route::post('/upload-randoms', [App\Http\Controllers\RandomNameSurnameController::class, 'storeFromFile'])->name('randoms.upload');
    Route::get('/export-randoms/{name}', [App\Http\Controllers\RandomNameSurnameController::class, 'export'])->name('randoms.export');
    Route::delete('/delete-name/{id}', [App\Http\Controllers\RandomNameSurnameController::class, 'deleteName'])->name('randoms.name.delete');
    Route::delete('/delete-surname/{id}', [App\Http\Controllers\RandomNameSurnameController::class, 'deleteSurname'])->name('randoms.surname.delete');
    Route::get('/store-name', [App\Http\Controllers\RandomNameSurnameController::class, 'storeNameView'])->name('randoms.store.view.name');
    Route::get('/store-surname', [App\Http\Controllers\RandomNameSurnameController::class, 'storeSurnameView'])->name('randoms.store.view.surname');
    Route::post('/store-name', [App\Http\Controllers\RandomNameSurnameController::class, 'storeName'])->name('randoms.store.name');
    Route::post('/store-surname', [App\Http\Controllers\RandomNameSurnameController::class, 'storeSurname'])->name('randoms.store.surname');
    Route::post('/random-generator', [App\Http\Controllers\RandomNameSurnameController::class, 'generator'])->name('randoms.generator');

    // Excel Formatter
    Route::get('/leads', [App\Http\Controllers\ExcelFormatterController::class, 'index'])->name('leads');
    Route::post('/excel-upload', [App\Http\Controllers\ExcelFormatterController::class, 'uploadFile'])->name('upload.file');
    Route::post('/excel-download', [App\Http\Controllers\ExcelFormatterController::class, 'downloadFile'])->name('download.file');

    // Settings
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
});
