@extends('layouts.app')
@section('title', 'Usuarios Admin — Incluy Admin')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-[#0A0E27]">Usuarios Admin</h1>
        <p class="text-[#6B7C93] text-sm mt-1">{{ count($usuarios) }} usuarios registrados</p>
    </div>
    <a href="{{ route('admin-usuarios.create') }}"
       class="px-4 py-2 rounded-lg text-white text-sm font-medium hover:opacity-90 transition"
       style="background: linear-gradient(135deg, #004494, #3C2D6D)">
        + Nuevo usuario
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-[#F0F4F8]">
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Usuario</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Email</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Rol</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Creado</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($usuarios as $u)
            <tr class="hover:bg-[#F0F4F8]/50 transition">
                <td class="px-4 py-3 font-medium text-[#1E2749]">
                    {{ $u->username }}
                    @if(session('admin.id') == $u->id)
                        <span class="ml-1 text-xs text-[#6B7C93]">(tú)</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-[#6B7C93]">{{ $u->email }}</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $u->role === 'super_admin' ? 'bg-purple-50 text-purple-700' : ($u->role === 'admin' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                        {{ $u->role }}
                    </span>
                </td>
                <td class="px-4 py-3 text-[#6B7C93] text-xs">{{ \Carbon\Carbon::parse($u->created_at)->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin-usuarios.edit', $u->id) }}" class="text-[#004494] hover:underline text-xs mr-3">Editar</a>
                    @if(session('admin.id') != $u->id)
                    <form method="POST" action="{{ route('admin-usuarios.destroy', $u->id) }}" class="inline"
                          x-data x-on:submit.prevent="if(confirm('¿Eliminar este usuario?')) $el.submit()">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-xs">Eliminar</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-[#6B7C93]">No hay usuarios registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
