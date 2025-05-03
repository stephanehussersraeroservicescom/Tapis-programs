<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ImportProjects;
use App\Livewire\ProjectDashboard;


Route::get('/', function () {
    return view('welcome');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// }); 

Route::middleware(['auth'])->group(function () {
    Route::get('/import', ImportProjects::class)->name('import');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', ProjectDashboard::class)->name('dashboard');
});
use App\Livewire\TestComponent;

Route::get('/test-livewire', TestComponent::class);


// Route::get('/dashboard', ProjectDashboard::class)->name('dashboard');