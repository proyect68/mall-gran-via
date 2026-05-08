<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tienda;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Tienda::orderBy('id_tienda', 'desc')->paginate(15);
        return view('admin.stores.index', compact('stores'));
    }

    public function edit(Tienda $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Tienda $store)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'ubicacion' => ['nullable', 'string', 'max:100'],
            'horario' => ['nullable', 'string', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
        ]);

        $store->update($request->only('nombre', 'descripcion', 'ubicacion', 'horario', 'telefono', 'email'));

        return redirect()->route('admin.stores.index')->with('success', 'Tienda actualizada exitosamente.');
    }

    public function toggleStatus(Tienda $store)
    {
        $nuevoEstado = in_array($store->estado, ['activa', 'abierto']) ? 'inactiva' : 'activa';
        $store->update(['estado' => $nuevoEstado]);

        $status = $nuevoEstado === 'activa' ? 'habilitada' : 'deshabilitada';
        return back()->with('success', "Tienda {$status} exitosamente.");
    }

    public function destroy(Tienda $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')->with('success', 'Tienda eliminada de forma permanente.');
    }
}
