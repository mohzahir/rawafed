<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DoctorWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $doctorName;
    public $candidateCode;

    public function __construct($doctorName, $candidateCode)
    {
        $this->doctorName = $doctorName;
        $this->candidateCode = $candidateCode;
    }

    public function build()
    {
        return $this->subject('روافد: تم استلام ملفك المهني بنجاح')
                    ->view('emails.doctor-welcome');
    }
}