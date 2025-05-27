<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Redirigir después de restablecer la contraseña.
     *
     * @var string
     */
    protected $redirectTo = '/login';
}
