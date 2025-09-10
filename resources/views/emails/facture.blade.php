<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Votre facture</title>
</head>
<body>
<p>Bonjour {{ $facture->client->nom }},</p>

<p>Merci pour votre commande ! Veuillez trouver votre facture en pièce jointe.</p>

<p>Montant total : {{ $facture->montant_total }} €</p>

<p>Cordialement,<br>L’équipe de la boulangerie</p>
</body>
</html>
