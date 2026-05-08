<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validatePassword = function ($attribute, $value, $fail) {
            $hasLetter = preg_match('/[a-zA-Z\p{L}]/u', $value);
            $hasNumber = preg_match('/\d/', $value);
            $specialChars = '!@#$%^&*()_+-=[]{};\'",./<>?|\\';
            $hasSpecial = false;
            foreach (str_split($specialChars) as $char) {
                if (strpos($value, $char) !== false) {
                    $hasSpecial = true;
                    break;
                }
            }
            
            if (!$hasLetter || !$hasNumber || !$hasSpecial) {
                $fail('La contraseña debe contener letras, números y caracteres especiales.');
            }
        };

        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed', $validatePassword],
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'current_password.current_password' => 'La contraseña actual es incorrecta.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede exceder 255 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
