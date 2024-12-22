<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Specialite;



class SpecialiteController extends Controller
{
    public function index()
    {
        $specialites = Specialite::all();
        return response()->json($specialites);
    }

    /**
     * Créer une nouvelle spécialité.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Création de la spécialité
        $specialite = Specialite::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return response()->json($specialite, 201); // Retourne la spécialité créée
    }

    /**
     * Afficher une spécialité spécifiée.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $specialite = Specialite::find($id);

        if (!$specialite) {
            return response()->json(['message' => 'Spécialité non trouvée'], 404);
        }

        return response()->json($specialite, 200);
    }

    /**
     * Mettre à jour une spécialité spécifiée.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $specialite = Specialite::find($id);

        if (!$specialite) {
            return response()->json(['message' => 'Spécialité non trouvée'], 404);
        }

        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Mise à jour des informations
        $specialite->update($request->only(['nom', 'description']));

        return response()->json($specialite, 200);
    }

    /**
     * Supprimer une spécialité spécifiée.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specialite = Specialite::find($id);

        if (!$specialite) {
            return response()->json(['message' => 'Spécialité non trouvée'], 404);
        }

        $specialite->delete();

        return response()->json(['message' => 'Spécialité supprimée avec succès'], 200);
    }
}
