@php $v = fn($field) => old($field, $profesional?->$field ?? ''); @endphp

{{-- SECCIÓN: Información básica --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Información básica
    </h3>
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
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">RUT</label>
            <input type="text" name="rut" value="{{ $v('rut') }}" placeholder="12345678-9"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Tipo / Profesión <span class="text-red-500">*</span></label>
            <input type="text" name="tipo_profesional" value="{{ $v('tipo_profesional') }}" required
                   placeholder="ej: Nutricionista, Psicólogo, Kinesiólogo..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Años de experiencia</label>
            <input type="number" name="anios_experiencia" value="{{ $v('anios_experiencia') }}" min="0" max="60"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Registro profesional</label>
            <input type="text" name="registro_profesional" value="{{ $v('registro_profesional') }}"
                   placeholder="Nº registro sanitario, patente, certificación..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Rango de precios</label>
            <input type="text" name="rango_precios" value="{{ $v('rango_precios') }}"
                   placeholder="ej: $30.000 - $50.000"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
    </div>
</div>

{{-- SECCIÓN: Descripción --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Sello inclusivo y especialidades
    </h3>
    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Descripción / "Sello Inclusivo"
                <span class="text-xs font-normal text-[#6B7C93] ml-1">¿Qué hace diferente tu servicio?</span>
            </label>
            <textarea name="descripcion" rows="3"
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('descripcion') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Especialidades
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Separadas por coma</span>
            </label>
            <textarea name="especialidades" rows="2"
                      placeholder="ej: Obesidad, Cirugía bariátrica, Alimentación complementaria"
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('especialidades') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Experiencia con condiciones específicas
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Autismo, Discapacidad visual, etc.</span>
            </label>
            <textarea name="experiencia_condiciones" rows="2"
                      placeholder="ej: Autismo, Discapacidad visual, Movilidad reducida, Neurodivergencias..."
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('experiencia_condiciones') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Palabras clave
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Para facilitar la búsqueda</span>
            </label>
            <input type="text" name="palabras_clave" value="{{ $v('palabras_clave') }}"
                   placeholder="ej: matemáticas, cerámica, nutrición infantil"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
    </div>
</div>

{{-- SECCIÓN: Ubicación y modalidad de atención --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Ubicación y modalidad de atención
    </h3>
    <div class="grid grid-cols-2 gap-4">
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

        @if(isset($comunas) && $comunas->count())
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Comuna</label>
            <select name="comuna_id" class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
                <option value="">— Sin comuna —</option>
                @foreach($comunas as $comuna)
                    <option value="{{ $comuna->id }}" {{ $v('comuna_id') == $comuna->id ? 'selected' : '' }}>
                        {{ $comuna->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="col-span-2">
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Dirección</label>
            <input type="text" name="direccion" value="{{ $v('direccion') }}"
                   placeholder="Dirección del local o domicilio donde atiende"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
    </div>

    <div class="flex flex-wrap gap-5 mt-4">
        <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
            <input type="checkbox" name="atiende_online" value="1" {{ $v('atiende_online') ? 'checked' : '' }} class="rounded"> Online
        </label>
        <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
            <input type="checkbox" name="atiende_presencial" value="1" {{ $v('atiende_presencial') ? 'checked' : '' }} class="rounded"> Presencial
        </label>
        <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
            <input type="checkbox" name="atiende_domicilio" value="1" {{ $v('atiende_domicilio') ? 'checked' : '' }} class="rounded"> Domicilio
        </label>
        <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
            <input type="checkbox" name="atiende_solo_comuna" value="1" {{ $v('atiende_solo_comuna') ? 'checked' : '' }} class="rounded"> Solo en la comuna indicada
        </label>
    </div>
</div>

{{-- SECCIÓN: Accesibilidad --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Accesibilidad
    </h3>
    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Idiomas y comunicación
                <span class="text-xs font-normal text-[#6B7C93] ml-1">LSCh, lectura fácil, apoyo pictográfico, etc.</span>
            </label>
            <textarea name="idiomas_comunicacion" rows="2"
                      placeholder="ej: Lengua de Señas Chilena (LSCh), Lectura fácil"
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('idiomas_comunicacion') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Ambiente sensorial
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Luz natural, reducción de ruido, etc.</span>
            </label>
            <textarea name="ambiente_sensorial" rows="2"
                      placeholder="ej: Espacio con luz natural, disminución de ruido, atención individual"
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('ambiente_sensorial') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Accesibilidad física
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Rampa, ascensor, baño accesible, etc.</span>
            </label>
            <textarea name="accesibilidad_fisica" rows="2"
                      placeholder="ej: Rampa de acceso, ascensor, baño accesible, estacionamiento prioritario"
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('accesibilidad_fisica') }}</textarea>
        </div>

        <div>
            <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
                <input type="checkbox" name="credencial_discapacidad" value="1"
                       {{ $v('credencial_discapacidad') ? 'checked' : '' }} class="rounded">
                Posee Credencial de Discapacidad (si es persona de la comunidad)
            </label>
        </div>
    </div>
</div>

{{-- SECCIÓN: Contacto --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Contacto
    </h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Email de contacto</label>
            <input type="email" name="email_contacto" value="{{ $v('email_contacto') }}"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Teléfono</label>
            <input type="text" name="telefono" value="{{ $v('telefono') }}"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
    </div>
</div>

{{-- SECCIÓN: Redes sociales y foto --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Foto y redes sociales
    </h3>
    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">URL de foto de perfil</label>
            <input type="url" name="foto_url" value="{{ $v('foto_url') }}"
                   placeholder="https://..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
            @if($v('foto_url'))
                <div class="mt-2 flex items-center gap-3">
                    <img src="{{ $v('foto_url') }}" alt="Foto" class="h-12 w-12 object-cover rounded-full border border-gray-200">
                    <span class="text-xs text-[#6B7C93]">Foto actual</span>
                </div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">LinkedIn</label>
            <input type="url" name="linkedin_url" value="{{ $v('linkedin_url') }}"
                   placeholder="https://linkedin.com/in/..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Instagram</label>
            <input type="url" name="instagram_url" value="{{ $v('instagram_url') }}"
                   placeholder="https://instagram.com/..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Facebook</label>
            <input type="url" name="facebook_url" value="{{ $v('facebook_url') }}"
                   placeholder="https://facebook.com/..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">TikTok</label>
            <input type="url" name="tiktok_url" value="{{ $v('tiktok_url') }}"
                   placeholder="https://tiktok.com/@..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Otra red social</label>
            <input type="text" name="otra_red_social" value="{{ $v('otra_red_social') }}"
                   placeholder="Nombre y URL de otra red"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
    </div>
</div>

{{-- SECCIÓN: Estado --}}
<div class="flex flex-wrap gap-6 pt-2">
    <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
        <input type="checkbox" name="activo" value="1" {{ $v('activo') ? 'checked' : '' }} class="rounded"> Activo
    </label>
    <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
        <input type="checkbox" name="verificado" value="1" {{ $v('verificado') ? 'checked' : '' }} class="rounded"> Verificado
    </label>
</div>
