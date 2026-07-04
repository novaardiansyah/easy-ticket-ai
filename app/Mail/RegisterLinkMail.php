<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterLinkMail extends Mailable
{
  use Queueable, SerializesModels;

  public function __construct(
    public string $email,
    public string $url
  ) {}

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Complete Your Registration - Easy Ticket AI',
    );
  }

  public function content(): Content
  {
    return new Content(
      view: 'emails.register-link',
      with: [
        'name' => explode('@', $this->email)[0] ?? '',
        'url' => $this->url,
      ],
    );
  }
}
