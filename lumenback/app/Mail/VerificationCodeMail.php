<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public readonly string $code,
        public readonly string $type,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your verification code');
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.verification-code');
    }
}
