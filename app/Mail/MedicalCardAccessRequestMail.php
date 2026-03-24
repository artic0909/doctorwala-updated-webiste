<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AccessRequest;

class MedicalCardAccessRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public AccessRequest $accessRequest;

    public function __construct(AccessRequest $accessRequest)
    {
        // Eager load doctor & patient — same as allRequests() controller
        $this->accessRequest = $accessRequest->load(['doctor', 'patient']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Medical Card Access Request — Doctorwala',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.medical-card-access-request',
            with: ['accessRequest' => $this->accessRequest]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}