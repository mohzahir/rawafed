<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $hrName;
    public $hospitalName;
    public $hrEmail;
    public $requestedCodes;

    public function __construct($hrName, $hospitalName, $hrEmail, $requestedCodes)
    {
        $this->hrName = $hrName;
        $this->hospitalName = $hospitalName;
        $this->hrEmail = $hrEmail;
        $this->requestedCodes = $requestedCodes;
    }

    public function build()
    {
        return $this->subject('🔔 طلب توظيف جديد من مستشفى: ' . $this->hospitalName)
                    ->view('emails.admin-alert');
    }
}