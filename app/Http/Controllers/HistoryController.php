<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Muestra el historial de búsquedas del usuario
     */
    public function index()
    {
        return view('history.index');
    }
}
