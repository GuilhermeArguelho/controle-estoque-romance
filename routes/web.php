<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\RepasseController;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    
    // Rota para EXIBIR o formulário (Método GET)
    Route::get('/repasses/novo', [RepasseController::class, 'create'])->name('repasses.create');
    
    // Rota para SALVAR os dados enviados pelo formulário (Método POST)
    Route::post('/repasses', [RepasseController::class, 'store'])->name('repasses.store');

});

require __DIR__.'/settings.php';
