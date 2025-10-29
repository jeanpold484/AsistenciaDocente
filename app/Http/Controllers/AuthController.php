<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar los datos
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string|min:4',
        ]);

        // Credenciales a verificar
        $credenciales = [
            'correo' => $request->correo,
            'password' => $request->contrasena, // usa getAuthPassword() de tu modelo Usuario
        ];

        // Intentar autenticación
        if (Auth::attempt($credenciales)) {

            $request->session()->regenerate();
            $user = Auth::user()->load('rol');

            // 🔒 Verificar si el usuario está activo
            if (!$user->activo) {
                Auth::logout();
                return back()
                    ->withErrors(['correo' => 'Usuario inactivo.'])
                    ->onlyInput('correo');
            }

            // Redirigir según rol
            $rol = strtolower($user->rol?->nombre ?? '');
            return match ($rol) {
                'docente' => redirect()->route('docente.dashboard'),
                'administrador' => redirect()->route('admin.dashboard'),
                'coordinador' => redirect()->route('coordinador.dashboard'),
                default => redirect()->route('home'),
            };
        }

        // Si las credenciales no son válidas
        return back()
            ->withErrors(['correo' => 'Credenciales inválidas'])
            ->onlyInput('correo');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
