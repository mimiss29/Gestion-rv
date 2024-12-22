<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rendezvous; 
use Illuminate\Support\Facades\Validator;


class RendezvousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $rendezvous = Rendezvous::with(['medecin', 'patient'])->get(); // Inclut les relations avec médecin et patient
        // return response()->json($rendezvous, 200);
        $rendezvous = Rendezvous::with(['medecin', 'patient'])->get();
        return response()->json($rendezvous, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'medecin_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'lieu' => 'required|string|max:255',
            'status' => 'required|string|in:en_attente,confirmé,annulé,terminé',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Création du rendez-vous
        $rendezvous = Rendezvous::create($request->all());
        return response()->json($rendezvous, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rendezvous = Rendezvous::with(['medecin', 'patient'])->find($id);

        if (!$rendezvous) {
            return response()->json(['message' => 'Rendez-vous non trouvé'], 404);
        }

        return response()->json($rendezvous, 200);
    }

    // RendezvousController.php
    public function getRendezvousByPatient($patientId)
    {
        $rendezvous = Rendezvous::with(['medecin'])
            ->where('patient_id', $patientId)
            ->get()
            ->map(function ($rendezvous) {
                // Supprimez le nom du patient
                unset($rendezvous->patient);
                return $rendezvous;
            });

        return response()->json($rendezvous, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rendezvous = Rendezvous::find($id);

        if (!$rendezvous) {
            return response()->json(['message' => 'Rendez-vous non trouvé'], 404);
        }

        // Validation des données
        $validator = Validator::make($request->all(), [
            'medecin_id' => 'sometimes|exists:users,id',
            'patient_id' => 'sometimes|exists:users,id',
            'date' => 'sometimes|date',
            'heure' => 'sometimes|date_format:H:i',
            'lieu' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|in:en_attente,confirmé,annulé,terminé',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Mise à jour des données
        $rendezvous->update($request->all());
        return response()->json($rendezvous, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $rendezvous = Rendezvous::find($id);

            if (!$rendezvous) {
                return response()->json(['message' => 'Rendez-vous non trouvé'], 404);
            }

            $rendezvous->delete();
            return response()->json(['message' => 'Rendez-vous supprimé avec succès'], 200);
        }

                public function getRendezvousByMedecin(Request $request)
        {
            $medecin = $request->user();
            $rendezvous = Rendezvous::where('medecin_id', $medecin->id)->get();

            return response()->json($rendezvous, 200);
        }

    }

