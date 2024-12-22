<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Specialite; 
use App\Models\Rendezvous;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne la liste en JSON
        $users = User::all(); // Récupère tous les utilisateurs
        return response()->json($users, 200); // Retourne la liste en JSON
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'sexe' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:255',
            'mdp' => 'required|string|min:8',
            'type' => 'required|string|max:255',
            'specialite_id' => 'nullable|exists:specialites,id',
            'medecin_id' => 'nullable|exists:users,id',
            'patient_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Préparation des données en fonction du type d'utilisateur
        $userData = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'sexe' => $request->sexe,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'mdp' => Hash::make($request->mdp),
            'type' => $request->type,
        ];

        if ($request->type === 'medecin') {
            $userData['specialite_id'] = $request->specialite_id;
        } elseif ($request->type === 'patient') {
            $userData['medecin_id'] = $request->medecin_id; // Assurez-vous que medecin_id est assigné ici
        }
    
        // Création de l'utilisateur
        $user = User::create($userData);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'telephone' => 'sometimes|string|max:20',
            'adresse' => 'sometimes|string|max:255',
            'sexe' => 'sometimes|in:homme,femme',
            'mdp' => 'sometimes|string|min:6',
            'type' => 'sometimes|string|in:medecin,patient,admin,secretaire',
            'specialite_id' => 'sometimes|exists:specialites,id',
            'medecin_id' => 'nullable|exists:users,id',
            'patient_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Mise à jour des informations
        $user->update($request->only([
            'nom', 'prenom', 'email', 'telephone', 'adresse', 'sexe', 'type', 'specialite_id'
        ]));


         // Gestion des types spécifiques
    if ($request->type === 'medecin' && $request->has('specialite_id')) {
        $user->specialite_id = $request->specialite_id;
    } elseif ($request->type === 'patient' && $request->has('medecin_id')) {
        $user->medecin_id = $request->medecin_id; // Assurez-vous que medecin_id est mis à jour ici
    }

       
        if ($request->has('mdp')) {
            $user->mdp = Hash::make($request->mdp);
            $user->save();
        }

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès'], 200);
    }

    /**
     * Get all medecins.
     */
    public function getMedecins()
    {
        // Correct eager load of the 'specialite' relationship (not 'specialite_id')
        $medecins = User::where('type', 'medecin')->with('specialite')->get();

        return response()->json($medecins);
    }

    /**
     * Get all patients.
     */
    public function getPatients()
    {
        $patients = User::where('type', 'patient')->get();
        return response()->json($patients);
    }

    /**
     * Take a rendez-vous.
     */
    public function prendreRendezVous(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medecin_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'heure' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Logique pour enregistrer le rendez-vous
        $rendezvous = [
            'medecin_id' => $request->medecin_id,
            'patient_id' => auth()->id(), // ID du patient connecté
            'date' => $request->date,
            'heure' => $request->heure,
        ];

        // Enregistrer le rendez-vous dans la base de données
        Rendezvous::create($rendezvous);

        return response()->json(['message' => 'Rendez-vous pris avec succès'], 201);
    }

    /**
     * Get medecin disponibilites.
     */
    public function getMedecinDisponibilites(string $medecin_id)
    {
        // Récupérer les créneaux horaires disponibles pour le médecin spécifique
        $slots = Slot::where('medecin_id', $medecin_id)
                      ->where('status', 'disponible') // Assurez-vous que le statut est 'disponible'
                      ->get();

        if ($slots->isEmpty()) {
            return response()->json(['message' => 'Aucun créneau disponible pour ce médecin'], 404);
        }

        return response()->json($slots, 200);
    }
}