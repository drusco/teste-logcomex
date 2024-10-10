<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        // parametros da busca
        $nome = $request->query('nome');
        $tipo = $request->query('tipo');

        // buscar pokemon
        $query = Pokemon::query();

        // aplicar os filtros da busca
        if ($nome) {
            $query->where('nome', 'LIKE', '%' . $nome . '%');
        }

        if ($tipo) {
            $query->where('tipo', 'LIKE', '%' . $tipo . '%');
        }

        // mostrar 20 resultados por pagina
        $pokemons = $query->paginate(20);

        // convertir hectogramos e decimetros
        $pokemons->transform(function ($pokemon) {
            $pokemon->peso = $pokemon->peso / 10; // kg
            $pokemon->altura = $pokemon->altura * 10; // cm
            return $pokemon;
        });

        // retorna a lista de pokemons
        return response()->json($pokemons);
    }

    public function show($id)
    {
        // buscar pokemon pelo id
        $pokemon = Pokemon::find($id);

        // mensagem de erro caso o pokemon não exista
        if (!$pokemon) {
            return Response::json([
                'error' => true, 
                'message' => 'Pokemon não encontrado'
            ], 404);
        }

        $pokemon->peso = $pokemon->peso / 10; // kg
        $pokemon->altura = $pokemon->altura * 10; // cm

        return Response::json($pokemon, 200);
    }
}
