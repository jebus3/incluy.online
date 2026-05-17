<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'organizaciones'   => DB::table('entidades')->count(),
            'profesionales'    => DB::table('profesionales')->count(),
            'admin_usuarios'   => DB::table('admin_users')->count(),
            'org_verificadas'  => DB::table('entidades')->where('verificada', true)->count(),
            'prof_verificados' => DB::table('profesionales')->where('verificado', true)->count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
