<?php

namespace App\Listeners;

use App\Events\LivraisonStatutUpdated;
use Illuminate\Support\Facades\Mail;

class SendLivraisonNotification
{
    public function handle(LivraisonStatutUpdated $event)
    {
        $livraison = $event->livraison;

        $client = $livraison->commande->client; // ⚠️ suppose que Livraison → Commande → Client est lié

        Mail::raw("Votre livraison est maintenant : " . $livraison->statut, function ($message) use ($client) {
            $message->to($client->email)
                ->subject("Mise à jour de votre livraison");
        });
    }
}
