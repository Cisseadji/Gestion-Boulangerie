<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $facture->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
    </style>
</head>
<body>
<h2>Facture #{{ $facture->id }}</h2>
<p>Date: {{ $facture->date_facture }}</p>
<p>Client: {{ $facture->client->nom }} ({{ $facture->client->email }})</p>
<table>
    <thead>
    <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($facture->commande->produits as $produit)
        <tr>
            <td>{{ $produit->nom }}</td>
            <td>{{ $produit->pivot->quantite }}</td>
            <td>{{ $produit->pivot->prix_unitaire }} €</td>
            <td>{{ $produit->pivot->quantite * $produit->pivot->prix_unitaire }} €</td>
        </tr>
    @endforeach
    </tbody>
</table>
<h3>Total: {{ $facture->montant_total }} €</h3>
</body>
</html>
