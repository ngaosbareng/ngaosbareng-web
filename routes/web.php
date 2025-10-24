<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LibraryController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// User's Own Content Routes
Route::middleware(['auth'])->group(function () {
    // Books Management - User's own books
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/books/{bookId}/chapters/{chapterId}/discussions', [BookController::class, 'discussions'])->name('books.discussions');
    
    // Masail Management - User's own masail
    Route::get('/masail', function () {
        return view('masail.index');
    })->name('masail.index');
    
    // Library - Browse other users' content
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::get('/library/books/{id}', [LibraryController::class, 'showBook'])->name('library.books.show');
    Route::get('/library/masail/{id}', [LibraryController::class, 'showMasail'])->name('library.masail.show');
});

// Exam Routes
Route::middleware(['auth'])->prefix('exams')->name('exams.')->group(function () {
    Route::get('/', [ExamController::class, 'index'])->name('index');
    Route::get('/start', [ExamController::class, 'start'])->name('start');
    Route::get('/{id}', [ExamController::class, 'show'])->name('show');
    Route::get('/results', [ExamController::class, 'results'])->name('results');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
