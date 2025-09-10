<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack_produit extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'packs_produits';
    public function pack()
    {
        return $this->belongsTo(Pack::class, 'id_pack');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}
