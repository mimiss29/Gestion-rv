<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecin;

class MedecinController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $medecins = Medecin::with('specialite') // Charger la relation 'specialite'
            ->where('nom', 'LIKE', "%{$query}%")
            ->orWhere('prenom', 'LIKE', "%{$query}%")
            ->orWhereHas('specialite', function ($q) use ($query) {
                $q->where('nom', 'LIKE', "%{$query}%");
            })
            ->orWhere('adresse', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($medecins, 200);
    }
}
