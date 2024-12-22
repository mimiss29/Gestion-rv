<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Importer la façade Mail
use App\Mail\ReservationConfirmed;  // Importer la classe ReservationConfirmed

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Récupérer les données du formulaire
        $subject = $request->input('subject');
        $body = $request->input('body');

        // Préparer les données de l'e-mail
        $mailData = [
            'title' => $subject,
            'body' => $body
        ];

        // Envoyer l'email en utilisant la classe ReservationConfirmed
        Mail::to('Dalaljamm@gmail.com')->send(new ReservationConfirmed($mailData));

        return response()->json(['message' => 'Email envoyé avec succès!']);
    }
}
