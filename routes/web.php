<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Projects\ImportProjectsComponent;
use App\Http\Livewire\Projects\ProjectDashboardComponent;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); 

Route::middleware(['auth'])->group(function () {
    Route::get('/projects/import', ImportProjectsComponent::class)->name('projects.import');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/projects/dashboard', ProjectDashboardComponent::class)->name('projects.dashboard');
});