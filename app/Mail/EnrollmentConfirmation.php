<?php
namespace App\Mail;
use App\Models\Academy\Package;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnrollmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public Package $package) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'You\'re enrolled: ' . $this->package->title);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.enrollment-confirmation');
    }
}
