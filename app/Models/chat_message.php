<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_message extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'id_expediteur');
    }

    /**
     * Le destinataire du message
     */
    public function destinataire()
    {
        return $this->belongsTo(User::class, 'id_destinataire');
    }

    protected static function booted()
    {
        static::creating(function ($message) {
            $message->date_envoi = now();
        });
    }
}
