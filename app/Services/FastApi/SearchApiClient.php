<?php

namespace App\Services\FastApi;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class SearchApiClient
{
    public function search(array $params): array
    {
        $response = Http::timeout(config('services.fastapi.timeout', 3))
            ->acceptJson()
            ->get(rtrim(config('services.fastapi.base_url'), '/').'/api/v1/busqueda', [
                'q' => $params['q'] ?? null,
                'pagina' => $params['page'] ?? 1,
                'precio_minimo' => $params['priceMin'] ?? null,
                'precio_maximo' => $params['priceMax'] ?? null,
                'tienda' => $params['storeFilter'] ?? null,
                'solo_ofertas' => $this->toBoolean($params['offerOnly'] ?? false),
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('FastAPI no devolvió una respuesta exitosa.');
        }

        return $response->json();
    }

    private function toBoolean(mixed $value): bool
    {
        return $value === true || $value === '1' || $value === 1 || $value === 'on';
    }
}
