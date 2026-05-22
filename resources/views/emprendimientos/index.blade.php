@extends('layouts.app')

@section('title', 'Emprendimientos — Incluy Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-[#0A0E27]">Emprendimientos</h1>
        <p class="text-[#6B7C93] text-sm mt-1">{{ $emprendimientos->total() }} registros totales</p>
    </div>
    <a href="/emprendimientos/create"
       class="px-4 py-2 rounded-lg text-white text-sm font-medium hover:opacity-90 transition"
       style="background: linear-gradient(135deg, #004494, #3C2D6D)">
        + Nuevo emprendimiento
    </a>
</div>

<form method="GET" class="flex gap-3 mb-5">
    <input type="text" name="buscar" value="{{ request('buscar') }}"
        placeholder="Buscar por nombre..."
        class="px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30 w-64">
    <select name="categoria" class="px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        <option value="">Todas las categorías</option>
        @foreach(['Alimentación','Juguetes didácticos','Ropa adaptada','Papelería','Artesanía','Tecnología asistiva','Servicios de apoyo','Educación y capacitación','Salud y bienestar','Belleza y cuidado personal','Hogar y decoración','Deporte y recreación','Otro'] as $cat)
            <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    <button type="submit" class="px-4 py-2 bg-[#004494] text-white rounded-lg text-sm hover:opacity-90 transition">Filtrar</button>
    @if(request('buscar') || request('categoria'))
        <a href="/emprendimientos" class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-[#6B7C93] hover:bg-gray-50 transition">Limpiar</a>
    @endif
</form>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-[#F0F4F8]">
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Marca</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Categoría</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Tipo</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Estado</th>
                <th class="text-left px-4 py-3 text-xs text-[#6B7C93] uppercase tracking-wider font-medium">Verificado</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($emprendimientos as $emp)
            <tr class="hover:bg-[#F0F4F8]/50 transition">
                <td class="px-4 py-3 font-medium text-[#1E2749]">{{ $emp->nombre_marca }}</td>
                <td class="px-4 py-3 text-[#6B7C93]">{{ $emp->categoria }}</td>
                <td class="px-4 py-3 text-[#6B7C93] text-xs">
                    @php
                        $tipos = ['persona_discapacidad' => 'Persona con discapacidad', 'cuidador' => 'Cuidador/a', 'inclusivo' => 'Inclusivo'];
                    @endphp
                    {{ $tipos[$emp->tipo_liderazgo] ?? '—' }}
                </td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $emp->activo ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $emp->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    @if($emp->verificado)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Verificado</span>
                    @else
                        <span class="text-[#6B7C93] text-xs">—</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="/emprendimientos/{{ $emp->id }}/edit" class="text-[#004494] hover:underline text-xs mr-3">Editar</a>
                    <form method="POST" action="/emprendimientos/{{ $emp->id }}" class="inline"
                          x-data x-on:submit.prevent="if(confirm('¿Eliminar este emprendimiento?')) $el.submit()">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-xs">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-[#6B7C93]">No hay emprendimientos registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $emprendimientos->links() }}
</div>
@endsection
