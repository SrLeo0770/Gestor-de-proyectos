<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProyectoCreadoMiembroMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $miembro;

    /**
     * Create a new message instance.
     */
    public function __construct($project, $miembro)
    {
        $this->project = $project;
        $this->miembro = $miembro;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Has sido agregado como miembro a un nuevo proyecto!'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.proyectos.miembro',
            with: [
                'project' => $this->project,
                'miembro' => $this->miembro
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
