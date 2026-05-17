<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin')) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario'  => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = DB::table('admin_users')
            ->where('username', $request->usuario)
            ->orWhere('email', $request->usuario)
            ->first();

        // password_verify handles both $2b$ (Node.js) and $2y$ (PHP) bcrypt prefixes
        if (!$admin || !password_verify($request->password, $admin->password_hash)) {
            return back()->withErrors(['usuario' => 'Credenciales incorrectas.'])->withInput();
        }

        session(['admin' => (array) $admin]);
        return redirect('/');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin');
        return redirect('/login');
    }
}
