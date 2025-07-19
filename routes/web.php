<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TicketController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return Inertia::render('Home');
    })->name('home');

    Route::get('/support', [TicketController::class, 'create'])->name('ticket.create');
    Route::post('/support', [TicketController::class, 'store'])->name('ticket.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
