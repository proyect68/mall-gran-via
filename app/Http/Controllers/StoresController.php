<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StoresController extends Controller
{
    /**
     * Mostrar listado de todas las tiendas
     */
    public function index()
    {
        $tiendas = Tienda::query()
            ->orderBy('nombre')
            ->get();

        $this->attachProductData($tiendas);

        $storesByCategory = $this->groupStoresByCategory($tiendas);

        return view('stores.index', compact('tiendas', 'storesByCategory'));
    }

    /**
     * Mostrar detalle de una tienda específica
     */
    public function show($store)
    {
        $tienda = $this->findStore($store);
        $productsQuery = $this->productsForStore($tienda);

        $productos = (clone $productsQuery)
            ->with(['categoria', 'subcategoria'])
            ->paginate(12);

        $tienda->setRelation('productos', (clone $productsQuery)->with(['categoria', 'subcategoria'])->get());

        return view('stores.show', compact('tienda', 'productos'));
    }

    private function findStore(string|int $store): Tienda
    {
        $keyName = (new Tienda())->getKeyName();

        return Tienda::query()
            ->when(is_numeric($store), fn ($query) => $query->where($keyName, $store))
            ->when(! is_numeric($store), fn ($query) => $query->where('nombre', $store))
            ->firstOrFail();
    }

    private function attachProductData($tiendas): void
    {
        $tiendas->each(function (Tienda $tienda) {
            $tienda->setRelation(
                'productos',
                $this->productsForStore($tienda)->with(['categoria', 'subcategoria'])->get()
            );
        });
    }

    private function groupStoresByCategory($tiendas)
    {
        $groups = collect();

        $tiendas->each(function (Tienda $tienda) use ($groups) {
            $categorias = $tienda->categorias;

            if ($categorias->isEmpty()) {
                $groups->put('Sin categoria', $groups->get('Sin categoria', collect())->push($tienda));
                return;
            }

            $categorias->each(function ($categoria) use ($groups, $tienda) {
                $name = $categoria->name ?? $categoria->nombre ?? 'Sin categoria';
                $groups->put($name, $groups->get($name, collect())->push($tienda));
            });
        });

        return $groups->sortKeys();
    }

    private function productsForStore(Tienda $tienda)
    {
        return Product::query()
            ->where(function ($query) use ($tienda) {
                if (Schema::hasColumn('productos', 'tienda_id') && $tienda->getKey()) {
                    $query->where('tienda_id', $tienda->getKey());
                }

                $query->orWhere('tienda', $tienda->nombre);
            })
            ->orderBy('nombre');
    }
}
