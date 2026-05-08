<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categoria', 'tienda')->orderBy('id', 'desc')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function edit(Product $product)
    {
        $product->load('categoria');
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'string', 'max:255'],
            'stock' => ['nullable', 'integer', 'min:0'],
        ]);

        $product->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'estado' => $product->estado === 'activo' ? 'inactivo' : 'activo'
        ]);

        $status = $product->estado === 'activo' ? 'habilitado' : 'deshabilitado';
        return back()->with('success', "Producto {$status} exitosamente.");
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado de forma permanente.');
    }
}
