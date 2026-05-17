@php $v = fn($field) => old($field, $profesional?->$field ?? ''); @endphp

<div class="grid grid-cols-2 gap-4">
    <div class="col-span-2">
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Nombre completo <span class="text-red-500">*</span></label>
        <input type="text" name="nombre_completo" value="{{ $v('nombre_completo') }}" required
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
    </div>

    <div>
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Slug <span class="text-red-500">*</span></label>
        <input type="text" name="slug" value="{{ $v('slug') }}" required
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
    </div>

    <div>
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Tipo <span class="text-red-500">*</span></label>
        <select name="tipo_profesional" required class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
            @foreach(['medico','psicologo','terapeuta_ocupacional','fonoaudiologo','kinesiologo','trabajador_social','educador_diferencial','interprete_lsch','tecnico','operario','oficio','otro'] as $tipo)
                <option value="{{ $tipo }}" {{ $v('tipo_profesional') == $tipo ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$tipo)) }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-span-2">
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Descripción</label>
        <textarea name="descripcion" rows="3"
                  class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('descripcion') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Email contacto</label>
        <input type="email" name="email_contacto" value="{{ $v('email_contacto') }}"
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
    </div>

    <div>
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Teléfono</label>
        <input type="text" name="telefono" value="{{ $v('telefono') }}"
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
    </div>

    <div class="col-span-2">
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">LinkedIn URL</label>
        <input type="url" name="linkedin_url" value="{{ $v('linkedin_url') }}"
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
    </div>
</div>

<div class="flex flex-wrap gap-6 pt-2">
    <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
        <input type="checkbox" name="activo" value="1" {{ $v('activo') ? 'checked' : '' }} class="rounded"> Activo
    </label>
    <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
        <input type="checkbox" name="verificado" value="1" {{ $v('verificado') ? 'checked' : '' }} class="rounded"> Verificado
    </label>
</div>
