<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Información de Usuario";

    public $data;
    public $password = "No se ha cambiado la contraseña";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $password)
    {
        $this->data = $data;
        
        if ($password != null) {
            $this->password = $password;
        }
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.user');
    }
}
