<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $guarded = [];
    use HasFactory;

    /**
     * Relation avec le client
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'id_client'); // 'id_client' correspond à la colonne FK dans la table factures
    }

    /**
     * Relation avec la commande (optionnel si tu veux lier facture → commande)
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }
}
