<!-- resources/views/emails/reservationConfirmed.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre rendez-vous</title>
</head>
<body>
    <h1>Confirmation de votre rendez-vous</h1>
    
    <p>Bonjour {{ $patientName }},</p>
    
    <p>Nous avons le plaisir de vous confirmer que votre rendez-vous avec Dr. {{ $medecinName }} a été réservé avec succès. Voici les détails :</p>

    <ul>
        <li><strong>Date :</strong> {{ \Carbon\Carbon::parse($dateRdv)->format('d/m/Y') }}</li>
        <li><strong>Heure :</strong> {{ \Carbon\Carbon::parse($heureRdv)->format('H:i') }}</li>
    </ul>

    <p>Merci pour votre réservation. Nous sommes impatients de vous voir lors de votre rendez-vous.</p>

    <p>Si vous avez des questions ou devez annuler ce rendez-vous, veuillez nous contacter.</p>
</body>
</html>
