<?php
namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiry;
    public $subject;
    public $recipientName;

    public function __construct(Enquiry $enquiry, $subject, $recipientName)
    {
        $this->enquiry = $enquiry;
        $this->subject = $subject;
        $this->recipientName = $recipientName;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.new_enquiry_mail')
                    ->with([
                        'recipientName' => $this->recipientName,
                    ]);
    }
}

