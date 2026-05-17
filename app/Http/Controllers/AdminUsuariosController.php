<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUsuariosController extends Controller
{
    public function index()
    {
        $usuarios = DB::table('admin_users')->orderBy('username')->get();
        return view('admin-usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin-usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100|unique:admin_users,username',
            'email'    => 'required|email|unique:admin_users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:super_admin,admin,editor',
        ]);

        DB::table('admin_users')->insert([
            'username'      => $request->username,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
            'role'          => $request->role,
            'created_at'    => now(),
        ]);

        return redirect()->route('admin-usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(string $id)
    {
        $usuario = DB::table('admin_users')->where('id', $id)->firstOrFail();
        return view('admin-usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|max:100|unique:admin_users,username,' . $id,
            'email'    => 'required|email|unique:admin_users,email,' . $id,
            'role'     => 'required|in:super_admin,admin,editor',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }

        DB::table('admin_users')->where('id', $id)->update($data);

        return redirect()->route('admin-usuarios.index')->with('success', 'Usuario actualizado.');
    }

    public function destroy(string $id)
    {
        $adminSession = session('admin');
        if ($adminSession && $adminSession['id'] == $id) {
            return back()->withErrors(['error' => 'No puedes eliminar tu propia cuenta.']);
        }

        DB::table('admin_users')->where('id', $id)->delete();
        return redirect()->route('admin-usuarios.index')->with('success', 'Usuario eliminado.');
    }
}
