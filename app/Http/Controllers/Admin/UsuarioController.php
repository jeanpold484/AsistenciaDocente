<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with(['rol','persona'])->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function edit(Usuario $usuario)
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('admin.usuarios.edit', compact('usuario','roles'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'nombre'     => ['required','string','max:120'],
            'correo'     => ['required','email','max:150', Rule::unique('usuarios','correo')->ignore($usuario->id)],
            'rol_id'     => ['required','exists:rols,id'],
            'activo'     => ['required','boolean'],
            'persona_id' => ['required','exists:personas,id'],
        ]);

        $usuario->update($data);

        return back()->with('status','Cuenta actualizada.');
    }

    // Cambiar sólo el nombre de usuario (alias/username)
    public function updateUsername(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'nombre' => ['required','string','max:120'],
        ]);

        $usuario->update(['nombre' => $data['nombre']]);

        return back()->with('status','Nombre de usuario actualizado.');
    }

    // Cambiar sólo la contraseña
    public function updatePassword(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'password_actual' => ['required'],
            'password'        => ['required','min:6','confirmed'], // requiere password_confirmation
        ]);

        // Opcional: si el admin puede forzar sin validar password actual, quita este if
        if (!Hash::check($data['password_actual'], $usuario->contrasena)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }

        $usuario->update([
            'contrasena' => Hash::make($data['password']),
        ]);

        return back()->with('status','Contraseña actualizada.');
    }
}
