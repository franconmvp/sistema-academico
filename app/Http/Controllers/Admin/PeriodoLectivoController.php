<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodoLectivo;
use Illuminate\Http\Request;

class PeriodoLectivoController extends Controller
{
    public function index()
    {
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')
            ->orderBy('semestre', 'desc')
            ->paginate(10);
        return view('admin.periodos.index', compact('periodos'));
    }

    public function create()
    {
        return view('admin.periodos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anio' => 'required|integer|min:2020|max:2050',
            'semestre' => 'required|in:I,II',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'activo' => 'boolean',
        ]);

        $validated['nombre'] = $validated['anio'] . '-' . $validated['semestre'];
        $validated['activo'] = $request->has('activo');

        // If setting as active, deactivate others
        if ($validated['activo']) {
            PeriodoLectivo::where('activo', true)->update(['activo' => false]);
        }

        PeriodoLectivo::create($validated);

        return redirect()->route('admin.periodos.index')
            ->with('success', 'Período lectivo creado correctamente.');
    }

    public function edit(PeriodoLectivo $periodo)
    {
        return view('admin.periodos.edit', compact('periodo'));
    }

    public function update(Request $request, PeriodoLectivo $periodo)
    {
        $validated = $request->validate([
            'anio' => 'required|integer|min:2020|max:2050',
            'semestre' => 'required|in:I,II',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'activo' => 'boolean',
        ]);

        $validated['nombre'] = $validated['anio'] . '-' . $validated['semestre'];
        $validated['activo'] = $request->has('activo');

        // If setting as active, deactivate others
        if ($validated['activo'] && !$periodo->activo) {
            PeriodoLectivo::where('activo', true)->update(['activo' => false]);
        }

        $periodo->update($validated);

        return redirect()->route('admin.periodos.index')
            ->with('success', 'Período lectivo actualizado correctamente.');
    }

    public function destroy(PeriodoLectivo $periodo)
    {
        if ($periodo->matriculas()->exists() || $periodo->asignacionesDocente()->exists()) {
            return back()->with('error', 'No se puede eliminar el período porque tiene datos asociados.');
        }

        $periodo->delete();

        return redirect()->route('admin.periodos.index')
            ->with('success', 'Período lectivo eliminado correctamente.');
    }

    public function setActive(PeriodoLectivo $periodo)
    {
        PeriodoLectivo::where('activo', true)->update(['activo' => false]);
        $periodo->update(['activo' => true]);

        return redirect()->route('admin.periodos.index')
            ->with('success', 'Período lectivo activado correctamente.');
    }
}
