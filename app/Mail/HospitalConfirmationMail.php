<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HospitalConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $hrName;
    public $hospitalName;
    public $requestedCodes;

    public function __construct($hrName, $hospitalName, $requestedCodes)
    {
        $this->hrName = $hrName;
        $this->hospitalName = $hospitalName;
        $this->requestedCodes = $requestedCodes; // مصفوفة بالأكواد
    }

    public function build()
    {
        return $this->subject('تأكيد استلام طلب الكوادر الطبية - منصة روافد')
                    ->view('emails.hospital-confirmation');
    }
}