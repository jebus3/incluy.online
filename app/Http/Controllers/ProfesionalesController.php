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
        return view('directorio.profesionales.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo'  => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:profesionales,slug',
            'tipo_profesional' => 'required|in:medico,psicologo,terapeuta_ocupacional,fonoaudiologo,kinesiologo,trabajador_social,educador_diferencial,interprete_lsch,tecnico,operario,oficio,otro',
            'descripcion'      => 'nullable|string',
            'email_contacto'   => 'nullable|email',
            'telefono'         => 'nullable|string|max:50',
            'linkedin_url'     => 'nullable|url',
            'verificado'       => 'boolean',
            'activo'           => 'boolean',
        ]);

        $data['id']         = \Illuminate\Support\Str::uuid();
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $data['verificado'] = $request->boolean('verificado');
        $data['activo']     = $request->boolean('activo');

        DB::table('profesionales')->insert($data);

        return redirect()->route('profesionales.index')->with('success', 'Profesional creado correctamente.');
    }

    public function edit(string $id)
    {
        $profesional = DB::table('profesionales')->where('id', $id)->firstOrFail();
        return view('directorio.profesionales.edit', compact('profesional'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre_completo'  => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:profesionales,slug,' . $id . ',id',
            'tipo_profesional' => 'required|in:medico,psicologo,terapeuta_ocupacional,fonoaudiologo,kinesiologo,trabajador_social,educador_diferencial,interprete_lsch,tecnico,operario,oficio,otro',
            'descripcion'      => 'nullable|string',
            'email_contacto'   => 'nullable|email',
            'telefono'         => 'nullable|string|max:50',
            'linkedin_url'     => 'nullable|url',
            'verificado'       => 'boolean',
            'activo'           => 'boolean',
        ]);

        $data['updated_at'] = now();
        $data['verificado'] = $request->boolean('verificado');
        $data['activo']     = $request->boolean('activo');

        DB::table('profesionales')->where('id', $id)->update($data);

        return redirect()->route('profesionales.index')->with('success', 'Profesional actualizado.');
    }

    public function destroy(string $id)
    {
        DB::table('profesionales')->where('id', $id)->delete();
        return redirect()->route('profesionales.index')->with('success', 'Profesional eliminado.');
    }
}
