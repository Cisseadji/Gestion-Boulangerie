<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat_message extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function expediteur(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'id_expediteur');
    }

    public function destinataire(): \Illuminate\Database\Eloquent\Relations\BelongsTo
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
