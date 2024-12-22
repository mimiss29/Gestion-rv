<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmed extends Mailable
{
   

    use Queueable, SerializesModels;

    public $patientName;
    public $medecinName;
    public $dateRdv;
    public $heureRdv;

    public function __construct($patientName, $medecinName, $dateRdv, $heureRdv)
    {
        $this->patientName = $patientName;
        $this->medecinName = $medecinName;
        $this->dateRdv = $dateRdv;
        $this->heureRdv = $heureRdv;
    }

    public function build()
    {
        return $this->subject('Confirmation de votre rendez-vous')
                    ->view('emails.reservationConfirmed')
                    ->with([
                        'patientName' => $this->patientName,
                        'medecinName' => $this->medecinName,
                        'dateRdv' => $this->dateRdv,
                        'heureRdv' => $this->heureRdv,
                    ]);
    }
}