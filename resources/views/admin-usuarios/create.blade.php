@extends('layouts.app')
@section('title', 'Nuevo Usuario — Incluy Admin')
@section('content')
<div class="mb-6">
    <a href="/admin-usuarios" class="text-sm text-[#6B7C93] hover:text-[#004494]">← Volver</a>
    <h1 class="text-2xl font-bold text-[#0A0E27] mt-2">Nuevo Usuario Admin</h1>
</div>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 max-w-md">
    <form method="POST" action="/admin-usuarios" class="space-y-4">
        @csrf
        @include('admin-usuarios._form', ['usuario' => null, 'passwordRequired' => true])
        <div class="pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-lg text-white text-sm font-medium hover:opacity-90 transition"
                    style="background: linear-gradient(135deg, #004494, #3C2D6D)">
                Crear usuario
            </button>
        </div>
    </form>
</div>
@endsection
