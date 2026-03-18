<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserController;

// ──── Authentification ────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ──── Routes protégées (tous les connectés) ────
Route::middleware('auth')->group(function () {

    Route::get('/', fn() => redirect()->route('depenses.index'));

    // Dépenses : accessible à tous les utilisateurs connectés
    Route::resource('depenses', DepenseController::class)->except(['show']);

    // ──── Routes réservées à l'admin ────
    Route::middleware('admin')->group(function () {
        Route::resource('etablissements', EtablissementController::class)->except(['show']);
        Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');
        Route::resource('users', UserController::class)->except(['show']);
    });
});
