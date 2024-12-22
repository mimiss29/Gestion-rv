<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SalleDeConsultation;

class SalleDeConsultationController extends Controller
{
    public function index()
    {
        $salles = SalleDeConsultation::all(); // Récupère toutes les salles de consultation
        return response()->json($salles, 200); // Retourne la liste des salles en JSON
    }

    /**
     * Créer une nouvelle salle de consultation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Création de la salle
        $salle = SalleDeConsultation::create([
            'nom' => $request->nom,
            'localisation' => $request->localisation,
        ]);

        return response()->json($salle, 201); // Retourne la salle de consultation créée
    }

    /**
     * Afficher une salle de consultation spécifiée.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salle = SalleDeConsultation::find($id);

        if (!$salle) {
            return response()->json(['message' => 'Salle de consultation non trouvée'], 404);
        }

        return response()->json($salle, 200);
    }

    /**
     * Mettre à jour une salle de consultation spécifiée.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $salle = SalleDeConsultation::find($id);

        if (!$salle) {
            return response()->json(['message' => 'Salle de consultation non trouvée'], 404);
        }

        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:255',
            'localisation' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Mise à jour des informations
        $salle->update($request->only(['nom', 'localisation']));

        return response()->json($salle, 200);
    }

    /**
     * Supprimer une salle de consultation spécifiée.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salle = SalleDeConsultation::find($id);

        if (!$salle) {
            return response()->json(['message' => 'Salle de consultation non trouvée'], 404);
        }

        $salle->delete();

        return response()->json(['message' => 'Salle de consultation supprimée avec succès'], 200);
    }
}
