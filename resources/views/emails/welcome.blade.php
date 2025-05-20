@component('mail::message')
# ¡Bienvenido, {{ $usuario->nombre }}!

Gracias por unirte a **PompitaWear**. Ya puedes empezar a explorar y crear tus outfits.

@component('mail::button', ['url' => route('home')])
Ir a la aplicación
@endcomponent

¡Disfruta!

Saludos,<br>
El equipo de PompitaWear
@endcomponent
