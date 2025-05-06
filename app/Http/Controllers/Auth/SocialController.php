<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class SocialController extends Controller
{
    /**
     * Redirige al usuario a Google para autenticarse.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja el callback de Google.
     */
    public function callback()
    {
        // En local a veces hay errores SSL; desactivar solo en local
        $client = new Client([
            'verify' => app()->environment('local') ? false : true,
        ]);

        $googleUser = Socialite::driver('google')
            ->setHttpClient($client)
            ->stateless()
            ->user();

        // 1) Intentamos por provider_id
        $user = Usuario::where('provider', 'google')
                       ->where('provider_id', $googleUser->getId())
                       ->first();

        // 2) Si no existe, buscamos por email
        if (!$user) {
            $user = Usuario::where('email', $googleUser->getEmail())->first();
            if ($user) {
                // Asociamos la cuenta existente a Google
                $user->provider    = 'google';
                $user->provider_id = $googleUser->getId();
                $user->foto_perfil = $googleUser->getAvatar();
                // Si no tiene rol, asignamos el rol "cliente" por defecto
                if (is_null($user->id_rol)) {
                    $user->id_rol = 2;
                }
                $user->save();
            }
        }

        // 3) Si sigue sin existir, lo creamos
        if (!$user) {
            $user = Usuario::create([
                'nombre'       => $googleUser->getName(),
                'email'        => $googleUser->getEmail(),
                'foto_perfil'  => $googleUser->getAvatar(),
                'provider'     => 'google',
                'provider_id'  => $googleUser->getId(),
                'password'     => bcrypt(Str::random(16)),
                'id_rol'       => 2,  // Rol "cliente" por defecto
            ]);
        }

        // 4) Nos aseguramos de que tenga rol asignado
        if (is_null($user->id_rol)) {
            $user->id_rol = 2;
            $user->save();
        }

        // 5) Logueamos al usuario
        Auth::login($user, true);

        return redirect()->route('home');
    }
}
