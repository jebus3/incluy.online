@extends('layouts.app')

@section('title', 'Organizaciones — Incluy Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-[#0A0E27]">Organizaciones</h1>
        <p class="text-[#6B7C93] text-sm mt-1">{{ $organizaciones->total() }} registros totales</p>
    </div>
    <a href="/directorio/create"
       class="px-4 py-2 rounded-lg text-white text-sm font-medium hover:opacity-90 transition"
       style="background: linear-gradient(135deg, #004494, #3C2D6D)">
        + Nueva organización
    </a>
</div>

{{-- Filtros --}}
<form method="GET" class="flex gap-3 mb-5">
    <input type="text" name="buscar" value="{{ request('buscar') }}"
        placeholder="Buscar por nombre..."
        class="px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30 w-64">
    <select name="tipo" class="px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        <option value="">Todos los tipos</option>
        @foreach(['empresa','ong','fundacion','clinica','colegio','municipio','otra'] as $tipo)
            <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
        @endforeach
    </select>
    <button type="submit" class="px-4 py-2 bg-[#004494] text-white rounded-lg text-sm hover:opacity-90 transition">Filtrar</button>
    @if(request('buscar') || request('tipo'))
        <a href="/directorio" class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-[#6B7C93] hover:bg-gray-50 transition">Limpiar</a>
    @endif
</form>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-[#F0F4F8]">
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Nombre</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Tipo</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Estado</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Verificada</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($organizaciones as $org)
            <tr class="hover:bg-[#F0F4F8]/50 transition">
                <td class="px-4 py-3 font-medium text-[#1E2749]">{{ $org->nombre }}</td>
                <td class="px-4 py-3 text-[#6B7C93]">{{ ucfirst($org->tipo) }}</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $org->activa ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $org->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    @if($org->verificada)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Verificada</span>
                    @else
                        <span class="text-[#6B7C93] text-xs">—</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="/directorio/{{ $org->id }}/edit" class="text-[#004494] hover:underline text-xs mr-3">Editar</a>
                    <form method="POST" action="/directorio/{{ $org->id }}" class="inline"
                          x-data x-on:submit.prevent="if(confirm('¿Eliminar esta organización?')) $el.submit()">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-xs">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-[#6B7C93]">No hay organizaciones registradas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $organizaciones->links() }}
</div>
@endsection
