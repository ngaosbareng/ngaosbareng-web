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

Route::middleware(['auth'])
    ->group(function () {
    
    // Books Routes
        Route::prefix('books')->name('books.')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('index');
        Route::get('/{book}/chapters', [BookController::class, 'chapters'])->name('chapters');
        Route::get('/chapters/{chapter}/discussions', [BookController::class, 'discussions'])->name('discussions');
        Route::get('/discussions/{discussion}', [BookController::class, 'showDiscussion'])->name('discussions.show');
        
        // Chapter management
        Route::put('/chapters/{chapter}', [BookController::class, 'updateChapter'])->name('chapters.update');
        
        // Discussion management
        Route::post('/chapters/{chapter}/discussions', [BookController::class, 'storeDiscussion'])->name('discussions.store');
        Route::delete('/discussions/{discussion}', [BookController::class, 'destroyDiscussion'])->name('discussions.destroy');
    });
    
    // Masail Management - User's own masail
    Route::view('/masail', 'masail.index')->name('masail.index');
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
