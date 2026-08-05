<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ChecklistItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('areas', AreaController::class);

    Route::resource('auditorias', AuditoriaController::class);

    Route::post('/auditorias/{auditoria}/checklist', [ChecklistItemController::class, 'store'])->name('checklist.store');
    Route::delete('/checklist/{checklistItem}', [ChecklistItemController::class, 'destroy'])->name('checklist.destroy');
});

require __DIR__.'/auth.php';
