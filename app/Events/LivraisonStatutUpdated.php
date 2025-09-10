<?php

namespace App\Events;

use App\Models\Livraison;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LivraisonStatutUpdated
{
    use Dispatchable, SerializesModels;

    public $livraison;

    public function __construct(Livraison $livraison)
    {
        $this->livraison = $livraison;
    }
}
