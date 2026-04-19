<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Muestra la lista de deseos del usuario
     */
    public function index()
    {
        return view('wishlist.index');
    }
}
