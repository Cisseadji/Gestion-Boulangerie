<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }

    // Optionnel : relation vers la commande
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }
}
