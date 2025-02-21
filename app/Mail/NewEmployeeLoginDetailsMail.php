<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\UserEmployee;

class NewEmployeeLoginDetailsMail extends Mailable
{
    use Queueable, SerializesModels;
    public $employee;
    public $password;


    public function __construct(UserEmployee $employee, $password)
    {
        $this->employee = $employee;
        $this->password = $password;
    }


    public function build()
    {
        return $this->view('emails.new_employee_login_details')
            ->subject('Nomads Holidays : Your Login Details')
            ->with([
                'password' => $this->password,
            ]);
    }
}
