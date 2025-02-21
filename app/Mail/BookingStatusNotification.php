<?php
namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param Booking $booking
     * @param string $subject
     */
    public function __construct(Booking $booking, $subject)
    {
        $this->booking = $booking;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.booking_status_notification');
    }
}
