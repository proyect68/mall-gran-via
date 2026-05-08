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
        if (Auth::check()) {
            // Si es administrador, redirigir al panel admin
            if (Auth::user()->role === 'administrador') {
                return redirect()->route('admin.dashboard');
            }

            // Si es cliente u otro rol, mostrar pantalla de cliente
            return redirect()->route('dashboard');
        }

        // Si no está autenticado, mostrar landing de bienvenida
        return view('home');
    }
}
