<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp, $email;

    public function __construct($otp, $email='')
    {
        $this->otp = $otp;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Rivi Notification',
    //     );
    // }

    public function build()
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Your OTP Code')
            ->view('emails.otp') // Chỉ định view cho email
            ->with([
                'otp' => $this->otp,
                'email' => $this->email
            ]);
    }
}
