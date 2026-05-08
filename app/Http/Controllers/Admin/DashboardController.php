<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tienda;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $productsCount = Product::count();
        $storesCount = Tienda::count();

        $activeUsers = User::where('estado', 'activo')->count();
        $activeProducts = Product::where('estado', 'activo')->count();
        $activeStores = Tienda::whereIn('estado', ['activa', 'abierto'])->count();

        return view('admin.dashboard', compact(
            'usersCount', 'productsCount', 'storesCount',
            'activeUsers', 'activeProducts', 'activeStores'
        ));
    }
}
