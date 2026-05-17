<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfesionalesController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('profesionales')->orderBy('nombre_completo');

        if ($request->filled('buscar')) {
            $query->where('nombre_completo', 'ilike', '%' . $request->buscar . '%');
        }
        if ($request->filled('tipo')) {
            $query->where('tipo_profesional', $request->tipo);
        }

        $profesionales = $query->paginate(20)->withQueryString();
        return view('directorio.profesionales.index', compact('profesionales'));
    }

    public function create()
    {
        $regiones = $this->getRegiones();
        $comunas  = $this->getComunas();
        return view('directorio.profesionales.create', compact('regiones', 'comunas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo'       => 'required|string|max:255',
            'slug'                  => 'required|string|max:255|unique:profesionales,slug',
            'tipo_profesional'      => 'required|string|max:100',
            'rut'                   => 'nullable|string|max:20',
            'descripcion'           => 'nullable|string',
            'email_contacto'        => 'nullable|email',
            'telefono'              => 'nullable|string|max:50',
            'linkedin_url'          => 'nullable|url',
            'instagram_url'         => 'nullable|url',
            'facebook_url'          => 'nullable|url',
            'tiktok_url'            => 'nullable|url',
            'otra_red_social'       => 'nullable|string|max:500',
            'foto_url'              => 'nullable|url',
            'region_id'             => 'nullable|uuid',
            'comuna_id'             => 'nullable|uuid',
            'direccion'             => 'nullable|string|max:500',
            'atiende_online'        => 'boolean',
            'atiende_presencial'    => 'boolean',
            'atiende_domicilio'     => 'boolean',
            'atiende_solo_comuna'   => 'boolean',
            'anios_experiencia'     => 'nullable|integer|min:0|max:60',
            'especialidades'        => 'nullable|string',
            'experiencia_condiciones' => 'nullable|string',
            'idiomas_comunicacion'  => 'nullable|string',
            'ambiente_sensorial'    => 'nullable|string',
            'accesibilidad_fisica'  => 'nullable|string',
            'credencial_discapacidad' => 'boolean',
            'registro_profesional'  => 'nullable|string|max:255',
            'rango_precios'         => 'nullable|string|max:100',
            'palabras_clave'        => 'nullable|string',
            'verificado'            => 'boolean',
            'activo'                => 'boolean',
        ]);

        $data['id']         = \Illuminate\Support\Str::uuid();
        $data['created_at'] = now();
        $data['updated_at'] = now();

        foreach (['verificado','activo','atiende_online','atiende_presencial','atiende_domicilio','atiende_solo_comuna','credencial_discapacidad'] as $bool) {
            $data[$bool] = $request->boolean($bool);
        }

        DB::table('profesionales')->insert($data);

        return redirect()->route('profesionales.index')->with('success', 'Profesional creado correctamente.');
    }

    public function edit(string $id)
    {
        $profesional = DB::table('profesionales')->where('id', $id)->firstOrFail();
        $regiones    = $this->getRegiones();
        $comunas     = $this->getComunas();
        return view('directorio.profesionales.edit', compact('profesional', 'regiones', 'comunas'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre_completo'       => 'required|string|max:255',
            'slug'                  => 'required|string|max:255|unique:profesionales,slug,' . $id . ',id',
            'tipo_profesional'      => 'required|string|max:100',
            'rut'                   => 'nullable|string|max:20',
            'descripcion'           => 'nullable|string',
            'email_contacto'        => 'nullable|email',
            'telefono'              => 'nullable|string|max:50',
            'linkedin_url'          => 'nullable|url',
            'instagram_url'         => 'nullable|url',
            'facebook_url'          => 'nullable|url',
            'tiktok_url'            => 'nullable|url',
            'otra_red_social'       => 'nullable|string|max:500',
            'foto_url'              => 'nullable|url',
            'region_id'             => 'nullable|uuid',
            'comuna_id'             => 'nullable|uuid',
            'direccion'             => 'nullable|string|max:500',
            'atiende_online'        => 'boolean',
            'atiende_presencial'    => 'boolean',
            'atiende_domicilio'     => 'boolean',
            'atiende_solo_comuna'   => 'boolean',
            'anios_experiencia'     => 'nullable|integer|min:0|max:60',
            'especialidades'        => 'nullable|string',
            'experiencia_condiciones' => 'nullable|string',
            'idiomas_comunicacion'  => 'nullable|string',
            'ambiente_sensorial'    => 'nullable|string',
            'accesibilidad_fisica'  => 'nullable|string',
            'credencial_discapacidad' => 'boolean',
            'registro_profesional'  => 'nullable|string|max:255',
            'rango_precios'         => 'nullable|string|max:100',
            'palabras_clave'        => 'nullable|string',
            'verificado'            => 'boolean',
            'activo'                => 'boolean',
        ]);

        $data['updated_at'] = now();

        foreach (['verificado','activo','atiende_online','atiende_presencial','atiende_domicilio','atiende_solo_comuna','credencial_discapacidad'] as $bool) {
            $data[$bool] = $request->boolean($bool);
        }

        DB::table('profesionales')->where('id', $id)->update($data);

        return redirect()->route('profesionales.index')->with('success', 'Profesional actualizado.');
    }

    public function destroy(string $id)
    {
        DB::table('profesionales')->where('id', $id)->delete();
        return redirect()->route('profesionales.index')->with('success', 'Profesional eliminado.');
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
