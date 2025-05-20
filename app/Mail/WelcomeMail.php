<?php

namespace App\Mail;

use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function build()
    {
        return $this
            ->subject('¡Bienvenido a Pompita Wear!')
            // indicamos que use nuestra vista HTML
            ->view('emails.welcome');
    }
}
