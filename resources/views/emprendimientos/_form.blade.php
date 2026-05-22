@php
    $v       = fn($field) => old($field, $emprendimiento?->$field ?? '');
    $autoSlug = (!isset($emprendimiento) || !$emprendimiento || !$emprendimiento->slug) ? 'true' : 'false';
    $categorias = ['Alimentación','Juguetes didácticos','Ropa adaptada','Papelería','Artesanía','Tecnología asistiva','Servicios de apoyo','Educación y capacitación','Salud y bienestar','Belleza y cuidado personal','Hogar y decoración','Deporte y recreación','Otro'];
@endphp

{{-- SECCIÓN: Información básica --}}
<div class="mb-6" x-data="{
    autoSlug: {{ $autoSlug }},
    slugify(t) {
        return t.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g,'')
            .replace(/[^a-z0-9\s]/g,'').trim().replace(/\s+/g,'-').replace(/-+/g,'-');
    },
    onNombre(val) { if (this.autoSlug) this.$refs.slug.value = this.slugify(val); }
}">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Información básica
    </h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Nombre de la marca/tienda <span class="text-red-500">*</span></label>
            <input type="text" name="nombre_marca" value="{{ $v('nombre_marca') }}" required
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
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Nombre del/los encargado/s <span class="text-red-500">*</span></label>
            <input type="text" name="nombre_encargados" value="{{ $v('nombre_encargados') }}" required
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">RUN/RUT</label>
            <input type="text" name="rut" value="{{ $v('rut') }}" placeholder="12345678-9"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Categoría <span class="text-red-500">*</span></label>
            <select name="categoria" required
                    class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
                <option value="">— Seleccionar —</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat }}" {{ $v('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">URL de imagen/logo</label>
            <input type="url" name="foto_url" value="{{ $v('foto_url') }}" placeholder="https://..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
            @if($v('foto_url'))
                <div class="mt-2 flex items-center gap-3">
                    <img src="{{ $v('foto_url') }}" alt="Logo" class="h-12 w-12 object-cover rounded-lg border border-gray-200">
                    <span class="text-xs text-[#6B7C93]">Imagen actual</span>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- SECCIÓN: Historia y perfil inclusivo --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Historia y perfil inclusivo
    </h3>
    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Historia del emprendimiento
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Un espacio para contar tu historia</span>
            </label>
            <textarea name="historia" rows="4"
                      placeholder="Cuéntanos cómo nació tu emprendimiento, tu motivación, tu trayectoria..."
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('historia') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Tipo de emprendimiento inclusivo</label>
            <select name="tipo_liderazgo"
                    class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
                <option value="">— Sin especificar —</option>
                <option value="persona_discapacidad" {{ $v('tipo_liderazgo') == 'persona_discapacidad' ? 'selected' : '' }}>Liderado por persona con discapacidad</option>
                <option value="cuidador" {{ $v('tipo_liderazgo') == 'cuidador' ? 'selected' : '' }}>Liderado por cuidador/a</option>
                <option value="inclusivo" {{ $v('tipo_liderazgo') == 'inclusivo' ? 'selected' : '' }}>Emprendimiento inclusivo (equipo mixto)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Producto/servicio adaptado
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Ej: Ropa con costuras planas, mordedores, agendas con pictogramas</span>
            </label>
            <textarea name="producto_servicio_adaptado" rows="3"
                      placeholder="Describe qué adaptaciones tienen tus productos o servicios..."
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('producto_servicio_adaptado') }}</textarea>
        </div>

        <div>
            <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
                <input type="checkbox" name="emplea_personas_discapacidad" value="1"
                       {{ $v('emplea_personas_discapacidad') ? 'checked' : '' }} class="rounded">
                El emprendimiento emplea a otras personas con discapacidad
            </label>
        </div>
    </div>
</div>

{{-- SECCIÓN: Venta y logística --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Venta y logística
    </h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Alcance de envíos</label>
            <select name="alcance_envios"
                    class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
                <option value="">— Sin especificar —</option>
                <option value="solo_comuna" {{ $v('alcance_envios') == 'solo_comuna' ? 'selected' : '' }}>Solo la comuna</option>
                <option value="region" {{ $v('alcance_envios') == 'region' ? 'selected' : '' }}>Solo la región</option>
                <option value="todo_chile" {{ $v('alcance_envios') == 'todo_chile' ? 'selected' : '' }}>Todo Chile</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Métodos de pago</label>
            <input type="text" name="metodos_pago" value="{{ $v('metodos_pago') }}"
                   placeholder="Efectivo, Transferencia, Webpay..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Punto de retiro físico
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Si tiene local o taller, indica dirección</span>
            </label>
            <input type="text" name="punto_retiro" value="{{ $v('punto_retiro') }}"
                   placeholder="Dirección del local o taller..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Accesibilidad del local
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Rampas, iluminación, ruidos, etc.</span>
            </label>
            <textarea name="accesibilidad_local" rows="2"
                      placeholder="ej: Rampa de acceso, luz natural, bajo nivel de ruido..."
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('accesibilidad_local') }}</textarea>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Accesibilidad en la compra
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Catálogo con audio, atención por WhatsApp con video LSCh, etc.</span>
            </label>
            <textarea name="accesibilidad_compra" rows="2"
                      placeholder="ej: Catálogo con descripción de audio, atención por WhatsApp con video para lengua de señas..."
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('accesibilidad_compra') }}</textarea>
        </div>

        <div x-data="{ show: {{ in_array($v('resolucion_sanitaria'), ['1','true',1,true], true) ? 'true' : 'false' }} }">
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">¿Resolución sanitaria? (si vende alimentos)</label>
            <select name="resolucion_sanitaria"
                    class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
                <option value="">— No aplica —</option>
                <option value="1" {{ $v('resolucion_sanitaria') == '1' || $v('resolucion_sanitaria') === true ? 'selected' : '' }}>Sí, cuenta con resolución sanitaria</option>
                <option value="0" {{ $v('resolucion_sanitaria') === '0' || $v('resolucion_sanitaria') === false ? 'selected' : '' }}>No</option>
            </select>
        </div>
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
                      placeholder="ej: Lengua de Señas Chilena (LSCh), Lectura fácil, Apoyo pictográfico"
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('idiomas_comunicacion') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Ambiente sensorial
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Luz natural, reducción de ruido, atención individual, etc.</span>
            </label>
            <textarea name="ambiente_sensorial" rows="2"
                      placeholder="ej: Espacio con luz natural, disminución de ruido, atención individual sin público"
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('ambiente_sensorial') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
                Accesibilidad física
                <span class="text-xs font-normal text-[#6B7C93] ml-1">Rampa, ascensor, baño accesible, estacionamiento prioritario, etc.</span>
            </label>
            <textarea name="accesibilidad_fisica" rows="2"
                      placeholder="ej: Rampa de acceso, ascensor, baño accesible, estacionamiento prioritario"
                      class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">{{ $v('accesibilidad_fisica') }}</textarea>
        </div>

        <div>
            <label class="flex items-center gap-2 text-sm text-[#1E2749] cursor-pointer">
                <input type="checkbox" name="credencial_discapacidad" value="1"
                       {{ $v('credencial_discapacidad') ? 'checked' : '' }} class="rounded">
                Posee Credencial de Discapacidad (si el encargado pertenece a la comunidad)
            </label>
        </div>
    </div>
</div>

{{-- SECCIÓN: Ubicación --}}
@if((isset($regiones) && $regiones->count()) || (isset($comunas) && $comunas->count()))
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Ubicación
    </h3>
    <div class="grid grid-cols-2 gap-4">
        @if(isset($regiones) && $regiones->count())
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Región</label>
            <select name="region_id" class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
                <option value="">— Sin región —</option>
                @foreach($regiones as $region)
                    <option value="{{ $region->id }}" {{ $v('region_id') == $region->id ? 'selected' : '' }}>{{ $region->nombre }}</option>
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
                    <option value="{{ $comuna->id }}" {{ $v('comuna_id') == $comuna->id ? 'selected' : '' }}>{{ $comuna->nombre }}</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>
</div>
@endif

{{-- SECCIÓN: Contacto --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Contacto
    </h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Correo de contacto</label>
            <input type="email" name="email_contacto" value="{{ $v('email_contacto') }}"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Teléfono</label>
            <input type="text" name="telefono" value="{{ $v('telefono') }}"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
        <div class="col-span-2">
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Sitio web</label>
            <input type="url" name="sitio_web" value="{{ $v('sitio_web') }}" placeholder="https://..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
    </div>
</div>

{{-- SECCIÓN: Redes sociales --}}
<div class="mb-6">
    <h3 class="text-sm font-semibold text-[#004494] uppercase tracking-wide mb-3 pb-1 border-b border-gray-200">
        Redes sociales
    </h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Instagram</label>
            <input type="url" name="instagram_url" value="{{ $v('instagram_url') }}" placeholder="https://instagram.com/..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Facebook</label>
            <input type="url" name="facebook_url" value="{{ $v('facebook_url') }}" placeholder="https://facebook.com/..."
                   class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1E2749] mb-1.5">TikTok</label>
            <input type="url" name="tiktok_url" value="{{ $v('tiktok_url') }}" placeholder="https://tiktok.com/@..."
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
