<!-- resources/views/emails/password_recovery.blade.php -->

@component('mail::message')
# Recuperación de Contraseña

¡Hola!

Estás recibiendo este correo porque hemos recibido una solicitud para restablecer la contraseña de tu cuenta.

@component('mail::button', ['url' => route('password.confirm', $token)])
Restablecer Contraseña
@endcomponent

Si no solicitaste restablecer tu contraseña, no es necesario realizar ninguna acción.

Gracias,
{{ config('app.name') }}
@endcomponent