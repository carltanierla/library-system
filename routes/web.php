<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/borrow-history', [BookController::class, 'getBooksBorrowHistory'])->name('borrow-history');

    Route::get('import-excel-file', function () {
        return Inertia::render('ImportFile');
    })->name('import-excel-file');

    Route::get('/master-list', [BookController::class, 'index'])->name('master-list');

    Route::post('book/import', [BookController::class, 'importBooks']);

    Route::post('book/create', [BookController::class, 'createBooks']);
});

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
