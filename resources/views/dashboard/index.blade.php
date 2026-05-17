@extends('layouts.app')

@section('title', 'Dashboard — Incluy Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-[#0A0E27]">Dashboard</h1>
    <p class="text-[#6B7C93] text-sm mt-1">Resumen del directorio Incluy</p>
</div>

<div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <p class="text-xs text-[#6B7C93] uppercase tracking-wider mb-2">Organizaciones</p>
        <p class="text-3xl font-bold text-[#004494]">{{ number_format($stats['organizaciones']) }}</p>
        <p class="text-xs text-[#6B7C93] mt-1">{{ $stats['org_verificadas'] }} verificadas</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <p class="text-xs text-[#6B7C93] uppercase tracking-wider mb-2">Profesionales</p>
        <p class="text-3xl font-bold text-[#004494]">{{ number_format($stats['profesionales']) }}</p>
        <p class="text-xs text-[#6B7C93] mt-1">{{ $stats['prof_verificados'] }} verificados</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <p class="text-xs text-[#6B7C93] uppercase tracking-wider mb-2">Admin Usuarios</p>
        <p class="text-3xl font-bold text-[#004494]">{{ $stats['admin_usuarios'] }}</p>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 gap-4 lg:grid-cols-2">
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <h2 class="font-semibold text-[#1E2749] mb-3">Accesos rápidos</h2>
        <div class="space-y-2">
            <a href="/directorio/create" class="flex items-center gap-2 text-sm text-[#004494] hover:underline">
                + Nueva organización
            </a>
            <a href="/directorio/profesionales/create" class="flex items-center gap-2 text-sm text-[#004494] hover:underline">
                + Nuevo profesional
            </a>
            <a href="/admin-usuarios/create" class="flex items-center gap-2 text-sm text-[#004494] hover:underline">
                + Nuevo usuario admin
            </a>
        </div>
    </div>
</div>
@endsection
