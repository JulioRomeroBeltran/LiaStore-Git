<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $correo;
    public $telefono;
    public $descripcion;

    /**
     * Create a new message instance.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->nombre = $data['Nombre'];
        $this->correo = $data['Correo'];
        $this->telefono = $data['telefono'];
        $this->descripcion = $data['descripcion'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact-form')
        ->subject('Nueva Solicitud de Contacto');
    }
    
}
