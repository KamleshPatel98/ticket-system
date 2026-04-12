<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return "Admin Panel";
        })->name('admin');
    });

    // Admin + Agent
    Route::middleware('role:admin,agent')->group(function () {
        Route::get('/manage-tickets', function () {
            return "Manage Tickets";
        });
    });

    // Admin + Customer
    Route::middleware('role:admin,customer')->group(function () {
        Route::get('/my-tickets', function () {
            return "My Tickets";
        });
    });
});

require __DIR__.'/auth.php';
