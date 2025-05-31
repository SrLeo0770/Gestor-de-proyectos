<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProyectoCreadoLiderMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $lider;

    /**
     * Create a new message instance.
     */
    public function __construct($project, $lider)
    {
        $this->project = $project;
        $this->lider = $lider;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Eres líder de un nuevo proyecto!'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.proyectos.lider',
            with: [
                'project' => $this->project,
                'lider' => $this->lider
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
