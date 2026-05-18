@php
    $v        = fn($field) => old($field, $org?->$field ?? '');
    $autoSlug = (!isset($org) || !$org || !$org->slug) ? 'true' : 'false';
@endphp

<div class="grid grid-cols-2 gap-4" x-data="{
    autoSlug: {{ $autoSlug }},
    slugify(t) {
        return t.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g,'')
            .replace(/[^a-z0-9\s]/g,'').trim().replace(/\s+/g,'-').replace(/-+/g,'-');
    },
    onNombre(val) { if (this.autoSlug) this.$refs.slug.value = this.slugify(val); }
}">
    <div class="col-span-2">
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Nombre <span class="text-red-500">*</span></label>
        <input type="text" name="nombre" value="{{ $v('nombre') }}" required
               @input="onNombre($event.target.value)"
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
    </div>

    <div>
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
            Slug <span class="text-red-500">*</span>
            <span x-show="autoSlug" class="text-xs font-normal text-[#6B7C93] ml-1">(auto)</span>
        </label>
        <input type="text" name="slug" value="{{ $v('slug') }}" required
               x-ref="slug"
               @input="autoSlug = false"
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
    </div>

    <div>
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Tipo <span class="text-red-500">*</span></label>
        <select name="tipo" required class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
            @foreach(['empresa','ong','fundacion','clinica','colegio','municipio','otra'] as $tipo)
                <option value="{{ $tipo }}" {{ $v('tipo') == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
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

    <div>
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Sitio web</label>
        <input type="url" name="sitio_web" value="{{ $v('sitio_web') }}"
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
    </div>

    <div>
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">RUT</label>
        <input type="text" name="rut" value="{{ $v('rut') }}"
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
    </div>

    <div class="col-span-2">
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">URL del logo</label>
        <input type="url" name="logo_url" value="{{ $v('logo_url') }}"
               placeholder="https://..."
               class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        @if($v('logo_url'))
            <div class="mt-2 flex items-center gap-3">
                <img src="{{ $v('logo_url') }}" alt="Logo" class="h-12 w-12 object-contain rounded border border-gray-200">
                <span class="text-xs text-[#6B7C93]">Logo actual</span>
            </div>
        @endif
    </div>

    @if(isset($regiones) && $regiones->count())
    <div>
        <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Región</label>
        <select name="region_id" class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
            <option value="">— Sin región —</option>
            @foreach($regiones as $region)
                <option value="{{ $region->id }}" {{ $v('region_id') == $region->id ? 'selected' : '' }}>
                    {{ $region->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    @endif
</div>

<div class="flex flex-wrap gap-6 pt-2">
    <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
        <input type="checkbox" name="activa" value="1" {{ $v('activa') ? 'checked' : '' }} class="rounded">
        Activa
    </label>
    <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
        <input type="checkbox" name="verificada" value="1" {{ $v('verificada') ? 'checked' : '' }} class="rounded">
        Verificada
    </label>
</div>
