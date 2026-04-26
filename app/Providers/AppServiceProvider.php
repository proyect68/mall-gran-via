<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;

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
        // Compartir datos disponibles con todas las vistas
        try {
            View::share([
                'availableStores' => Product::select('tienda')->distinct()->pluck('tienda')->filter()->values()->toArray(),
            ]);
        } catch (\Exception $e) {
            // Si la BD no está disponible, compartir array vacío
            View::share([
                'availableStores' => [],
            ]);
        }
    }
}
