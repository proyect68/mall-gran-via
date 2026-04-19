<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        try {
            return redirect()->away(
                'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
                    'client_id' => config('services.google.client_id'),
                    'redirect_uri' => config('services.google.redirect'),
                    'response_type' => 'code',
                    'scope' => 'openid email profile',
                    'access_type' => 'offline',
                ])
            );
        } catch (\Exception $exception) {
            Log::error('Google redirect error: ' . $exception->getMessage());
            return redirect()->route('error')->with('message', 'No se pudo conectar con Google');
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            if ($request->has('error')) {
                Log::warning('Google OAuth error: ' . $request->get('error'));
                return redirect()->route('error')->with('message', 'Google rechazó la solicitud de autenticación');
            }

            if (!$request->has('code')) {
                Log::error('No authorization code received from Google');
                return redirect()->route('error')->with('message', 'No se recibió código de autorización');
            }

            // Validar que los datos de configuración existan
            if (!config('services.google.client_id') || !config('services.google.client_secret')) {
                Log::error('Google credentials not configured');
                return redirect()->route('error')->with('message', 'Las credenciales de Google no están configuradas correctamente');
            }

            // Aquí iría la lógica de Socialite
            // Por ahora, retornamos error porque Socialite puede no estar completamente configurado
            return redirect()->route('error')->with('message', 'Se está configurando la autenticación con Google. Intenta registrarte o usando email y contraseña por ahora.');

        } catch (\Exception $exception) {
            Log::error('Google callback error: ' . $exception->getMessage());
            return redirect()->route('error')->with('message', 'Ocurrió un error al autenticar con Google: ' . $exception->getMessage());
        }
    }
}
