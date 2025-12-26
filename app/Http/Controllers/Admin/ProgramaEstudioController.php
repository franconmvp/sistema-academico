<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramaEstudio;
use Illuminate\Http\Request;

class ProgramaEstudioController extends Controller
{
    public function index()
    {
        $programas = ProgramaEstudio::withCount(['estudiantes', 'planesEstudio'])
            ->paginate(10);
        return view('admin.programas.index', compact('programas'));
    }

    public function create()
    {
        return view('admin.programas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:programas_estudio',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion_semestres' => 'required|integer|min:1|max:12',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        ProgramaEstudio::create($validated);

        return redirect()->route('admin.programas.index')
            ->with('success', 'Programa de estudio creado correctamente.');
    }

    public function show(ProgramaEstudio $programa)
    {
        $programa->load(['planesEstudio.unidadesDidacticas', 'estudiantes']);
        return view('admin.programas.show', compact('programa'));
    }

    public function edit(ProgramaEstudio $programa)
    {
        return view('admin.programas.edit', compact('programa'));
    }

    public function update(Request $request, ProgramaEstudio $programa)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:programas_estudio,codigo,' . $programa->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion_semestres' => 'required|integer|min:1|max:12',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        $programa->update($validated);

        return redirect()->route('admin.programas.index')
            ->with('success', 'Programa de estudio actualizado correctamente.');
    }

    public function destroy(ProgramaEstudio $programa)
    {
        if ($programa->estudiantes()->exists()) {
            return back()->with('error', 'No se puede eliminar el programa porque tiene estudiantes matriculados.');
        }

        $programa->delete();

        return redirect()->route('admin.programas.index')
            ->with('success', 'Programa de estudio eliminado correctamente.');
    }
}
