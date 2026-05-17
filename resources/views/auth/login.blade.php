<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Incluy Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-[#F0F4F8]">

    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4" style="background: linear-gradient(135deg, #004494, #3C2D6D)">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-[#0A0E27]">Incluy Admin</h1>
            <p class="text-[#6B7C93] text-sm mt-1">Panel de administración</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Usuario o email</label>
                    <input
                        type="text"
                        name="usuario"
                        value="{{ old('usuario') }}"
                        autofocus
                        class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition {{ $errors->has('usuario') ? 'border-red-400 bg-red-50' : 'focus:ring-[#004494]/30' }}"
                        placeholder="jesus.olivares"
                    >
                    @error('usuario')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30 focus:border-transparent transition"
                        placeholder="••••••••"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full py-2.5 rounded-lg text-white font-medium text-sm transition hover:opacity-90 active:scale-95"
                    style="background: linear-gradient(135deg, #004494, #3C2D6D)"
                >
                    Ingresar
                </button>
            </form>
        </div>
    </div>

</body>
</html>
