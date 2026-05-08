<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FastApi\SearchApiClient;
use Illuminate\Http\Request;

class AdminSearchController extends Controller
{
    public function search(Request $request)
    {
        $category = $request->input('category');
        $query = $request->input('q', '');

        try {
            // Llamamos al microservicio de Python
            $client = app(SearchApiClient::class);
            $results = $client->adminSearch($category, $query);
            
            \Log::info("Búsqueda Admin - Cat: $category, Query: $query, Resultados: " . count($results));

            return response()->json($results);
        } catch (\Throwable $th) {
            \Log::error("Error Búsqueda Admin: " . $th->getMessage());
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
