<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailables\Attachment;

class FactureMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public $facture) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre facture',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.facture', // une petite vue HTML pour le mail
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn() => Pdf::loadView('factures.pdf', ['facture' => $this->facture])->output(),
                'facture_'.$this->facture->id.'.pdf'
            ),
        ];
    }
}
