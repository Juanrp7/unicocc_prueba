<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        $q = Pokemon::query();

        // Búsqueda por nombre (ILIKE en Postgres)
        if ($search = $request->query('search')) {
            $q->whereRaw('name ILIKE ?', ["%{$search}%"]);
        }

        // Filtro por tipo (types es un array de strings) → whereJsonContains soporta Postgres
        if ($type = $request->query('type')) {
            $q->whereJsonContains('types', $type);
        }

        // Filtro por habilidad
        if ($ability = $request->query('ability')) {
            $q->whereJsonContains('abilities', $ability);
        }

        // Peso / altura
        if ($minWeight = $request->query('min_weight')) {
            $q->where('weight', '>=', (int)$minWeight);
        }
        if ($maxWeight = $request->query('max_weight')) {
            $q->where('weight', '<=', (int)$maxWeight);
        }
        if ($minHeight = $request->query('min_height')) {
            $q->where('height', '>=', (int)$minHeight);
        }
        if ($maxHeight = $request->query('max_height')) {
            $q->where('height', '<=', (int)$maxHeight);
        }

        // Orden opcional (por nombre, peso, etc.)
        $sort = $request->query('sort', 'name');
        $dir  = $request->query('dir', 'asc');
        $allowedSorts = ['name','weight','height','base_experience'];
        if (!in_array($sort, $allowedSorts)) $sort = 'name';
        if (!in_array(strtolower($dir), ['asc','desc'])) $dir = 'asc';

        $q->orderBy($sort, $dir);

        $perPage = min((int)$request->query('per_page', 20), 100);

        return response()->json($q->paginate($perPage));
    }

    public function show($id)
    {
        $pokemon = Pokemon::findOrFail($id);
        return response()->json($pokemon);
    }
}
