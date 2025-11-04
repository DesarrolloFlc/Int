<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Enviaremail extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;

    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject('Nuevo Requerimiento Creado')
                    ->view('emails.requerimiento')
                    ->with(['solicitud' => $this->solicitud]);
    }
}
