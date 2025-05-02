<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Livewire\Projects\ImportProjectsComponent;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the Livewire component
        \Livewire\Livewire::component('projects.import', ImportProjectsComponent::class);
    }
}   



