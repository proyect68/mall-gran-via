<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Rol::orderBy('id')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validateName = function ($attribute, $value, $fail) {
            $fieldName = str_replace('_', ' ', $attribute);
            if (!preg_match('/^[a-zA-Z\s\p{L}]+$/u', $value)) {
                $fail('El ' . $fieldName . ' solo puede contener letras y espacios.');
            }
        };

        $request->validate([
            'name' => ['required', 'string', 'max:50', $validateName],
            'apellido_paterno' => ['required', 'string', 'max:50', $validateName],
            'apellido_materno' => ['required', 'string', 'max:50', $validateName],
            'email' => [
                'required', 'string', 'email', 'max:255', 'unique:'.User::class,
                function ($attribute, $value, $fail) {
                    if (!str_ends_with(strtolower($value), '@gmail.com')) {
                        $fail('El correo electrónico debe ser una cuenta de Gmail (@gmail.com).');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', Rule::in(Rol::pluck('nombre')->toArray())],
        ]);

        User::create([
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'estado' => 'activo',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user)
    {
        $roles = Rol::orderBy('id')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validateName = function ($attribute, $value, $fail) {
            $fieldName = str_replace('_', ' ', $attribute);
            if (!preg_match('/^[a-zA-Z\s\p{L}]+$/u', $value)) {
                $fail('El ' . $fieldName . ' solo puede contener letras y espacios.');
            }
        };

        $request->validate([
            'name' => ['required', 'string', 'max:50', $validateName],
            'apellido_paterno' => ['required', 'string', 'max:50', $validateName],
            'apellido_materno' => ['required', 'string', 'max:50', $validateName],
            'role' => ['required', 'string', Rule::in(Rol::pluck('nombre')->toArray())],
        ]);

        $user->update([
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes deshabilitar tu propia cuenta.');
        }

        $user->update([
            'estado' => $user->estado === 'activo' ? 'inactivo' : 'activo'
        ]);

        $status = $user->estado === 'activo' ? 'rehabilitado' : 'deshabilitado';
        return back()->with('success', "Usuario {$status} exitosamente.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado de forma permanente.');
    }
}
