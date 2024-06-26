<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\RecipeDetail;
use App\Livewire\RecipeList;
use Illuminate\Support\Facades\Route;

Route::get('/', RecipeList::class)->name('recipes.index');
Route::get('recipes/{id}', RecipeDetail::class)->name('recipes.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
