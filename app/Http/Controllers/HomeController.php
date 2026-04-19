<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Mostrar la pantalla apropiada según estado de autenticación
     */
    public function index()
    {
        // Si está autenticado, mostrar pantalla de cliente
        if (Auth::check()) {
            return view('welcome');
        }

        // Si no está autenticado, mostrar landing de bienvenida
        return view('home');
    }
}
