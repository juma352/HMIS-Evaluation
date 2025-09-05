<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ProfileController;

    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorEvaluationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{vendorEvaluation}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{vendorEvaluation}/pdf', [ReportController::class, 'downloadPdf'])->name('reports.downloadPdf');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/evaluation/{type}', [VendorEvaluationController::class, 'show'])->name('evaluations.show');
    Route::post('/evaluation', [VendorEvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/evaluations', [VendorEvaluationController::class, 'index'])->name('evaluations.index');
    Route::get('/evaluations/{id}', [VendorEvaluationController::class, 'showResult'])->name('evaluations.showResult');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

require __DIR__.'/auth.php';