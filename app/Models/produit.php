<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Promotion;
use App\Models\Commande;

class Produit extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'allergenes' => 'array',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commandes_produits', 'id_produit', 'id_commande')
            ->withPivot('quantite', 'prix_unitaire')
            ->withTimestamps();
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'produits_promotions', 'produit_id', 'promotion_id');
    }
}
