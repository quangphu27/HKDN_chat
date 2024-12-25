<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $password;
    public $user;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('Emails.user-password')
                    ->subject('Your Account Password');
    }
}