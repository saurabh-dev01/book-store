<?php

use Illuminate\Support\Facades\Route;
use App\Models\books;

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


// disable registre and reset password
Auth::routes(
    [
        'register' => false,
        'reset' => false
    ]
);



// home page
Route::get('/', [App\Http\Controllers\bookController::class, 'elastic_paginator']);

// single book detail
Route::get('/Book/Detail/{isbn}', [App\Http\Controllers\bookController::class, 'check_single_book'])->name('view.book');



Route::group(['middleware' => 'auth'], function () {
    Route::get('/Dashboard', [App\Http\Controllers\bookController::class, 'fetch_in_dashboard'])->name('books');
    Route::get('/save', [App\Http\Controllers\bookController::class, 'save'])->name('save');
    
    Route::get('/Sync', [App\Http\Controllers\bookController::class, 'syncAllBooksToElasticsearch'])->name('books.sync');
    
    Route::get('Book/Add', function () {
        return view('Admin/add_book');
    })->name('book.add');
    Route::post('/Book/Save', [App\Http\Controllers\bookController::class, 'save'])->name('book.save');
    Route::get('/Book/Edit/{id}', [App\Http\Controllers\bookController::class, 'editbook'])->name('books.edit');
    Route::post('/Book/Update/{id}', [App\Http\Controllers\bookController::class, 'update'])->name('books.update');
    Route::get('/Book/Delete/{id}', [App\Http\Controllers\bookController::class, 'delete'])->name('books.delete');
    
});