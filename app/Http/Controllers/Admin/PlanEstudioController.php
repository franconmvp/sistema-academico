<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanEstudio;
use App\Models\ProgramaEstudio;
use Illuminate\Http\Request;

class PlanEstudioController extends Controller
{
    public function index()
    {
        $planes = PlanEstudio::with('programaEstudio')
            ->withCount('unidadesDidacticas')
            ->paginate(10);
        return view('admin.planes.index', compact('planes'));
    }

    public function create()
    {
        $programas = ProgramaEstudio::activo()->get();
        return view('admin.planes.create', compact('programas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'programa_estudio_id' => 'required|exists:programas_estudio,id',
            'codigo' => 'required|string|max:50|unique:planes_estudio',
            'nombre' => 'required|string|max:255',
            'anio_inicio' => 'required|integer|min:2000|max:2050',
            'descripcion' => 'nullable|string',
            'vigente' => 'boolean',
        ]);

        $validated['vigente'] = $request->has('vigente');

        PlanEstudio::create($validated);

        return redirect()->route('admin.planes.index')
            ->with('success', 'Plan de estudio creado correctamente.');
    }

    public function show(PlanEstudio $plan)
    {
        $plan->load(['programaEstudio', 'unidadesDidacticas' => function ($query) {
            $query->orderBy('ciclo')->orderBy('nombre');
        }]);
        return view('admin.planes.show', compact('plan'));
    }

    public function edit(PlanEstudio $plan)
    {
        $programas = ProgramaEstudio::activo()->get();
        return view('admin.planes.edit', compact('plan', 'programas'));
    }

    public function update(Request $request, PlanEstudio $plan)
    {
        $validated = $request->validate([
            'programa_estudio_id' => 'required|exists:programas_estudio,id',
            'codigo' => 'required|string|max:50|unique:planes_estudio,codigo,' . $plan->id,
            'nombre' => 'required|string|max:255',
            'anio_inicio' => 'required|integer|min:2000|max:2050',
            'descripcion' => 'nullable|string',
            'vigente' => 'boolean',
        ]);

        $validated['vigente'] = $request->has('vigente');

        $plan->update($validated);

        return redirect()->route('admin.planes.index')
            ->with('success', 'Plan de estudio actualizado correctamente.');
    }

    public function destroy(PlanEstudio $plan)
    {
        if ($plan->estudiantes()->exists()) {
            return back()->with('error', 'No se puede eliminar el plan porque tiene estudiantes asignados.');
        }

        $plan->delete();

        return redirect()->route('admin.planes.index')
            ->with('success', 'Plan de estudio eliminado correctamente.');
    }
}
