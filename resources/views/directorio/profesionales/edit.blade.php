@extends('layouts.app')
@section('title', 'Editar Profesional — Incluy Admin')
@section('content')
<div class="mb-6">
    <a href="/directorio/profesionales" class="text-sm text-[#6B7C93] hover:text-[#004494]">← Volver</a>
    <h1 class="text-2xl font-bold text-[#0A0E27] mt-2">Editar: {{ $profesional->nombre_completo }}</h1>
</div>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 max-w-2xl">
    <form method="POST" action="/directorio/profesionales/{{ $profesional->id }}" class="space-y-4">
        @csrf @method('PUT')
        @include('directorio.profesionales._form', ['profesional' => $profesional])
        <div class="pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-lg text-white text-sm font-medium hover:opacity-90 transition"
                    style="background: linear-gradient(135deg, #004494, #3C2D6D)">
                Guardar cambios
            </button>
        </div>
    </form>
</div>
@endsection
