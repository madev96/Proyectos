<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('dashboard')->middleware('auth')->group(function(){
    Route::get('contacts',[ContactController::class,'index'])->name('contact.index');
    Route::get('contacts/create', [ContactController::class,'create'])->name('contact.create');
    Route::post('contacts',[ContactController::class,'store'])->name('contact.store');
    Route::get('contacts/{contact}/edit',[ContactController::class,'edit'])->name('contact.edit');
    Route::post('contacts/{contact}', [ContactController::class,'update'])->name('contact.update');
    Route::delete('contacts/{contact}', [ContactController::class,'destroy'])->name('contact.destroy');

});


require __DIR__.'/auth.php';
