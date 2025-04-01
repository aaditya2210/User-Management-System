<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $otpCode;

    public function __construct($otp)
    {
        $this->otpCode = $otp;
    }

    public function build()
    {
        return $this->subject('Your Security Verification Code')
                    ->view('emails.otp')
                    ->with([
                        'otp' => $this->otpCode
                    ]);
    }
}
