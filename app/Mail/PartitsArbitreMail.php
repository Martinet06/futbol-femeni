<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PartitsArbitreMail extends Mailable
{
    use Queueable, SerializesModels;

    public $arbitre;
    public $partits;

    public function __construct(User $arbitre, $partits)
    {
        $this->arbitre = $arbitre;
        $this->partits = $partits;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Els teus partits com a àrbitre - Guia de Futbol Femení',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.partits-arbitre',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
