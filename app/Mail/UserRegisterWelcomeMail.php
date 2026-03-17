<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Utils\CardGenerator;
use Illuminate\Mail\Mailables\Attachment;

class UserRegisterWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Doctorwala.info - Your Medical Journey Starts Here!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user-register-email',
            with: [
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $cardPath = CardGenerator::generate($this->user);
        
        if ($cardPath && file_exists($cardPath)) {
            return [
                Attachment::fromPath($cardPath)
                    ->as('Doctorwala_Medical_Card.png')
                    ->withMime('image/png'),
            ];
        }

        return [];
    }
}
