<?php
namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class BookingConfirmationClient extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $subject;
    public $recipientName;

    /**
     * Create a new message instance.
     *
     * @param Booking $booking
     * @param string $subject
     */
    public function __construct($booking, $subject, $recipientName)
    {
        $this->booking = $booking;
        $this->subject = $subject;
        $this->recipientName = $recipientName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail =  $this->subject($this->subject)
                    ->view('emails.booking_confirmation_mail_client')
                    ->with([
                        'booking' => $this->booking,
                        'recipientName' => $this->recipientName
                    ]);

                    // Fetch the file from the URL and attach it
        if (!empty($this->booking->url)) {
            try {
                $fileContents = Http::get($this->booking->url)->body();
                $filename = basename(parse_url($this->booking->url, PHP_URL_PATH));

                $mail->attachData($fileContents, $filename, [
                    'mime' => 'application/pdf',
                ]);
            } catch (\Exception $e) {
                \Log::error("Failed to attach PDF file from URL: " . $e->getMessage());
            }
        }

        return $mail;
    }
}
