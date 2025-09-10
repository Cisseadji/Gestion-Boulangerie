<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Produit;

class Commande extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relation avec les produits via la table pivot
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commandes_produits', 'id_commande', 'id_produit')
            ->withPivot('quantite', 'prix_unitaire')
            ->withTimestamps();
    }

    // Relation avec le client
    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }
}
