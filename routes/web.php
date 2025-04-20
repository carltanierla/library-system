<?php

use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('import-excel-file', function () {
        return Inertia::render('ImportFile');
    })->name('import-excel-file');

    Route::get('/master-list', function () {
        return Inertia::render('MasterList', [
            'books' => Book::paginate(10)
        ]);
    })->name('master-list');

    Route::post('book/import', [BookController::class, 'importBooks'])->middleware(['auth', 'verified']);
});

Route::post('book/import', [BookController::class, 'importBooks'])->middleware(['auth', 'verified']);

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
