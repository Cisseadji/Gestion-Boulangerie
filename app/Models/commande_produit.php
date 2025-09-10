<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande_produit extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'commandes_produits';

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}
