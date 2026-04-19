<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Muestra las notificaciones del usuario
     */
    public function index()
    {
        return view('notifications.index');
    }
}
