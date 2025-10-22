<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pokemon_id' => ['required','exists:pokemon,id'],
            'user_ref'   => ['nullable','string','max:255'],
        ]);

        $favorite = Favorite::firstOrCreate([
            'pokemon_id' => $validated['pokemon_id'],
            'user_ref'   => $validated['user_ref'] ?? 'guest',
        ]);

        return response()->json([
            'ok' => true,
            'favorite' => $favorite
        ], 201);
    }
}
