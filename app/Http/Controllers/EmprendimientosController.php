<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmprendimientosController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('emprendimientos')->orderBy('nombre_marca');

        if ($request->filled('buscar')) {
            $query->where('nombre_marca', 'ilike', '%' . $request->buscar . '%');
        }
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $emprendimientos = $query->paginate(20)->withQueryString();
        return view('emprendimientos.index', compact('emprendimientos'));
    }

    public function create()
    {
        $regiones = $this->getRegiones();
        $comunas  = $this->getComunas();
        return view('emprendimientos.create', compact('regiones', 'comunas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_marca'               => 'required|string|max:255',
            'slug'                       => 'required|string|max:255|unique:emprendimientos,slug',
            'nombre_encargados'          => 'required|string|max:255',
            'rut'                        => 'nullable|string|max:20',
            'categoria'                  => 'required|string|max:100',
            'historia'                   => 'nullable|string',
            'tipo_liderazgo'             => 'nullable|in:persona_discapacidad,cuidador,inclusivo',
            'producto_servicio_adaptado' => 'nullable|string',
            'emplea_personas_discapacidad' => 'boolean',
            'accesibilidad_compra'       => 'nullable|string',
            'alcance_envios'             => 'nullable|in:solo_comuna,region,todo_chile',
            'punto_retiro'               => 'nullable|string',
            'accesibilidad_local'        => 'nullable|string',
            'metodos_pago'               => 'nullable|string|max:255',
            'resolucion_sanitaria'       => 'nullable|boolean',
            'idiomas_comunicacion'       => 'nullable|string',
            'ambiente_sensorial'         => 'nullable|string',
            'accesibilidad_fisica'       => 'nullable|string',
            'credencial_discapacidad'    => 'boolean',
            'sitio_web'                  => 'nullable|url|max:500',
            'email_contacto'             => 'nullable|email',
            'telefono'                   => 'nullable|string|max:50',
            'instagram_url'              => 'nullable|url|max:500',
            'facebook_url'               => 'nullable|url|max:500',
            'tiktok_url'                 => 'nullable|url|max:500',
            'otra_red_social'            => 'nullable|string|max:500',
            'foto_url'                   => 'nullable|url|max:500',
            'region_id'                  => 'nullable|uuid',
            'comuna_id'                  => 'nullable|uuid',
            'verificado'                 => 'boolean',
            'activo'                     => 'boolean',
        ]);

        $data['id']         = \Illuminate\Support\Str::uuid();
        $data['created_at'] = now();
        $data['updated_at'] = now();

        foreach (['emplea_personas_discapacidad', 'credencial_discapacidad', 'verificado', 'activo'] as $bool) {
            $data[$bool] = $request->boolean($bool);
        }
        $data['resolucion_sanitaria'] = $request->filled('resolucion_sanitaria')
            ? $request->boolean('resolucion_sanitaria')
            : null;

        DB::table('emprendimientos')->insert($data);

        return redirect()->route('emprendimientos.index')->with('success', 'Emprendimiento creado correctamente.');
    }

    public function edit(string $id)
    {
        $emprendimiento = DB::table('emprendimientos')->where('id', $id)->firstOrFail();
        $regiones = $this->getRegiones();
        $comunas  = $this->getComunas();
        return view('emprendimientos.edit', compact('emprendimiento', 'regiones', 'comunas'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre_marca'               => 'required|string|max:255',
            'slug'                       => 'required|string|max:255|unique:emprendimientos,slug,' . $id . ',id',
            'nombre_encargados'          => 'required|string|max:255',
            'rut'                        => 'nullable|string|max:20',
            'categoria'                  => 'required|string|max:100',
            'historia'                   => 'nullable|string',
            'tipo_liderazgo'             => 'nullable|in:persona_discapacidad,cuidador,inclusivo',
            'producto_servicio_adaptado' => 'nullable|string',
            'emplea_personas_discapacidad' => 'boolean',
            'accesibilidad_compra'       => 'nullable|string',
            'alcance_envios'             => 'nullable|in:solo_comuna,region,todo_chile',
            'punto_retiro'               => 'nullable|string',
            'accesibilidad_local'        => 'nullable|string',
            'metodos_pago'               => 'nullable|string|max:255',
            'resolucion_sanitaria'       => 'nullable|boolean',
            'idiomas_comunicacion'       => 'nullable|string',
            'ambiente_sensorial'         => 'nullable|string',
            'accesibilidad_fisica'       => 'nullable|string',
            'credencial_discapacidad'    => 'boolean',
            'sitio_web'                  => 'nullable|url|max:500',
            'email_contacto'             => 'nullable|email',
            'telefono'                   => 'nullable|string|max:50',
            'instagram_url'              => 'nullable|url|max:500',
            'facebook_url'               => 'nullable|url|max:500',
            'tiktok_url'                 => 'nullable|url|max:500',
            'otra_red_social'            => 'nullable|string|max:500',
            'foto_url'                   => 'nullable|url|max:500',
            'region_id'                  => 'nullable|uuid',
            'comuna_id'                  => 'nullable|uuid',
            'verificado'                 => 'boolean',
            'activo'                     => 'boolean',
        ]);

        $data['updated_at'] = now();

        foreach (['emplea_personas_discapacidad', 'credencial_discapacidad', 'verificado', 'activo'] as $bool) {
            $data[$bool] = $request->boolean($bool);
        }
        $data['resolucion_sanitaria'] = $request->filled('resolucion_sanitaria')
            ? $request->boolean('resolucion_sanitaria')
            : null;

        DB::table('emprendimientos')->where('id', $id)->update($data);

        return redirect()->route('emprendimientos.index')->with('success', 'Emprendimiento actualizado.');
    }

    public function destroy(string $id)
    {
        DB::table('emprendimientos')->where('id', $id)->delete();
        return redirect()->route('emprendimientos.index')->with('success', 'Emprendimiento eliminado.');
    }

    private function getRegiones()
    {
        try {
            return DB::table('regiones')->orderBy('nombre')->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    private function getComunas()
    {
        try {
            return DB::table('comunas')->orderBy('nombre')->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}
