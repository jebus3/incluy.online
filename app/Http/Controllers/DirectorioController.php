<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectorioController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('entidades')->orderBy('nombre');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'ilike', '%' . $request->buscar . '%');
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $organizaciones = $query->paginate(20)->withQueryString();
        return view('directorio.index', compact('organizaciones'));
    }

    public function create()
    {
        return view('directorio.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'         => 'required|string|max:255',
            'slug'           => 'required|string|max:255|unique:entidades,slug',
            'tipo'           => 'required|in:empresa,ong,fundacion,clinica,colegio,municipio,otra',
            'descripcion'    => 'nullable|string',
            'email_contacto' => 'nullable|email',
            'telefono'       => 'nullable|string|max:50',
            'sitio_web'      => 'nullable|url',
            'verificada'     => 'boolean',
            'activa'         => 'boolean',
        ]);

        $data['id']         = \Illuminate\Support\Str::uuid();
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $data['verificada'] = $request->boolean('verificada');
        $data['activa']     = $request->boolean('activa');

        DB::table('entidades')->insert($data);

        return redirect()->route('directorio.index')->with('success', 'Organización creada correctamente.');
    }

    public function edit(string $id)
    {
        $org = DB::table('entidades')->where('id', $id)->firstOrFail();
        return view('directorio.edit', compact('org'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre'         => 'required|string|max:255',
            'slug'           => 'required|string|max:255|unique:entidades,slug,' . $id . ',id',
            'tipo'           => 'required|in:empresa,ong,fundacion,clinica,colegio,municipio,otra',
            'descripcion'    => 'nullable|string',
            'email_contacto' => 'nullable|email',
            'telefono'       => 'nullable|string|max:50',
            'sitio_web'      => 'nullable|url',
            'verificada'     => 'boolean',
            'activa'         => 'boolean',
        ]);

        $data['updated_at'] = now();
        $data['verificada'] = $request->boolean('verificada');
        $data['activa']     = $request->boolean('activa');

        DB::table('entidades')->where('id', $id)->update($data);

        return redirect()->route('directorio.index')->with('success', 'Organización actualizada.');
    }

    public function destroy(string $id)
    {
        DB::table('entidades')->where('id', $id)->delete();
        return redirect()->route('directorio.index')->with('success', 'Organización eliminada.');
    }
}
