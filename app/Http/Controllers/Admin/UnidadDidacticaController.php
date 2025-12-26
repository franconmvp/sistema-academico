<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanEstudio;
use App\Models\UnidadDidactica;
use Illuminate\Http\Request;

class UnidadDidacticaController extends Controller
{
    public function index(Request $request)
    {
        $query = UnidadDidactica::with('planEstudio.programaEstudio');
        
        if ($request->filled('plan_id')) {
            $query->where('plan_estudio_id', $request->plan_id);
        }
        
        $unidades = $query->orderBy('ciclo')->orderBy('nombre')->paginate(15);
        $planes = PlanEstudio::with('programaEstudio')->vigente()->get();
        
        return view('admin.unidades.index', compact('unidades', 'planes'));
    }

    public function create(Request $request)
    {
        $planes = PlanEstudio::with('programaEstudio')->vigente()->get();
        $planSeleccionado = $request->plan_id;
        return view('admin.unidades.create', compact('planes', 'planSeleccionado'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_estudio_id' => 'required|exists:planes_estudio,id',
            'codigo' => 'required|string|max:50',
            'nombre' => 'required|string|max:255',
            'ciclo' => 'required|integer|min:1|max:12',
            'creditos' => 'required|integer|min:1|max:10',
            'horas_semanales' => 'required|integer|min:1|max:40',
            'tipo' => 'required|in:obligatorio,electivo',
            'descripcion' => 'nullable|string',
        ]);

        // Check unique codigo within plan
        $exists = UnidadDidactica::where('plan_estudio_id', $validated['plan_estudio_id'])
            ->where('codigo', $validated['codigo'])
            ->exists();
        
        if ($exists) {
            return back()->withErrors(['codigo' => 'El código ya existe en este plan de estudio.'])->withInput();
        }

        UnidadDidactica::create($validated);

        return redirect()->route('admin.unidades.index', ['plan_id' => $validated['plan_estudio_id']])
            ->with('success', 'Unidad didáctica creada correctamente.');
    }

    public function edit(UnidadDidactica $unidad)
    {
        $planes = PlanEstudio::with('programaEstudio')->vigente()->get();
        return view('admin.unidades.edit', compact('unidad', 'planes'));
    }

    public function update(Request $request, UnidadDidactica $unidad)
    {
        $validated = $request->validate([
            'plan_estudio_id' => 'required|exists:planes_estudio,id',
            'codigo' => 'required|string|max:50',
            'nombre' => 'required|string|max:255',
            'ciclo' => 'required|integer|min:1|max:12',
            'creditos' => 'required|integer|min:1|max:10',
            'horas_semanales' => 'required|integer|min:1|max:40',
            'tipo' => 'required|in:obligatorio,electivo',
            'descripcion' => 'nullable|string',
        ]);

        // Check unique codigo within plan
        $exists = UnidadDidactica::where('plan_estudio_id', $validated['plan_estudio_id'])
            ->where('codigo', $validated['codigo'])
            ->where('id', '!=', $unidad->id)
            ->exists();
        
        if ($exists) {
            return back()->withErrors(['codigo' => 'El código ya existe en este plan de estudio.'])->withInput();
        }

        $unidad->update($validated);

        return redirect()->route('admin.unidades.index', ['plan_id' => $validated['plan_estudio_id']])
            ->with('success', 'Unidad didáctica actualizada correctamente.');
    }

    public function destroy(UnidadDidactica $unidad)
    {
        if ($unidad->matriculaDetalles()->exists()) {
            return back()->with('error', 'No se puede eliminar porque hay matrículas asociadas.');
        }

        $planId = $unidad->plan_estudio_id;
        $unidad->delete();

        return redirect()->route('admin.unidades.index', ['plan_id' => $planId])
            ->with('success', 'Unidad didáctica eliminada correctamente.');
    }
}
