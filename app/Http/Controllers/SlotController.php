<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\User;
use App\Models\Medecin; 
use App\Models\Patient; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\ReservationConfirmed;

class SlotController extends Controller
{
    // Méthode pour récupérer tous les créneaux
    public function index()
    {
        $slots = Slot::all();
        return response()->json($slots);
    }

    // Méthode pour récupérer tous les créneaux pour un médecin spécifique
    // SlotController.php

public function getSlotsByMedecin($medecinId)
{
    $slots = Slot::where('medecin_id', $medecinId)
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->date_debut)->format('Y-m-d');
        });

    Log::info('Slots for medecin ' . $medecinId, $slots->toArray());

    return response()->json($slots);
}


    // Méthode pour vérifier la disponibilité d'un créneau
    public function checkAvailability($id)
    {
        $slot = Slot::find($id);
        if ($slot && $slot->est_reserve == 0) {
            return response()->json(['available' => true]);
        }
        return response()->json(['available' => false]);
    }

    public function reserveSlot(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'slot_id' => 'required|exists:slots,id',
            'patient_id' => 'required|exists:users,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Récupérer le créneau
        $slot = Slot::find($request->slot_id);
    
        if (!$slot) {
            return response()->json(['message' => 'Créneau non trouvé'], 404);
        }
    
        if ($slot->est_reserve == 1) {
            return response()->json(['message' => 'Ce créneau est déjà réservé'], 400);
        }
    
        // Récupérer le patient
        $patient = User::find($request->patient_id);  // Récupérer le patient par ID
    
        if (!$patient) {
            return response()->json(['message' => 'Patient non trouvé'], 404);
        }
    
        // Réserver le créneau pour ce patient
        $slot->patient_id = $patient->id;
        $slot->est_reserve = 1;
        $slot->statut = 'réservé';
        $slot->save();
    
        // Récupérer le médecin associé au créneau
        $medecin = Medecin::find($slot->medecin_id);
    
        if (!$medecin) {
            return response()->json(['message' => 'Médecin non trouvé'], 404);
        }
    
        // Envoyer l'email de confirmation
        try {
            Mail::to($patient->email)->send(new ReservationConfirmed(
                $patient->name,  // Nom du patient
                $medecin->name,  // Nom du médecin
                $slot->date_debut,  // Date du créneau
                $slot->heure_debut  // Heure du créneau
            ));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email: ' . $e->getMessage());
            return response()->json(['message' => 'Réservation effectuée, mais échec de l\'envoi de l\'email'], 500);
        }
    
        return response()->json(['message' => 'Réservation effectuée et email envoyé !'], 200);
    }
    
    
    // Ajouter un créneau
public function addSlot(Request $request)
{
    // Validation des données
    $validated = $request->validate([
        'medecin_id' => 'required|exists:users,id',
        'date_debut' => 'required|date|after:now',
        'date_fin' => 'required|date|after:date_debut',
        'statut' => 'required|in:disponible,réservé,non disponible',
    ]);

    // Créer un nouveau créneau avec les données validées
    $slot = Slot::create([
        'medecin_id' => $validated['medecin_id'],
        'date_debut' => $validated['date_debut'],
        'date_fin' => $validated['date_fin'],
        'statut' => $validated['statut'],
        'est_reserve' => false, // Par défaut, un créneau n'est pas réservé
    ]);

    return response()->json(['message' => 'Créneau ajouté avec succès', 'slot' => $slot], 201);
}
}
