<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramaEstudio;
use App\Models\ReglaPromocion;
use App\Models\Turno;
use Illuminate\Http\Request;

class ReglaPromocionController extends Controller
{
    public function index(Request $request)
    {
        $query = ReglaPromocion::with(['programaEstudio', 'turno']);
        
        if ($request->filled('programa_id')) {
            $query->where('programa_estudio_id', $request->programa_id);
        }
        
        $reglas = $query->orderBy('programa_estudio_id')
            ->orderBy('turno_id')
            ->orderBy('ciclo')
            ->paginate(15);
            
        $programas = ProgramaEstudio::activo()->get();
        
        return view('admin.reglas.index', compact('reglas', 'programas'));
    }

    public function create()
    {
        $programas = ProgramaEstudio::activo()->get();
        $turnos = Turno::all();
        return view('admin.reglas.create', compact('programas', 'turnos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'programa_estudio_id' => 'required|exists:programas_estudio,id',
            'turno_id' => 'required|exists:turnos,id',
            'ciclo' => 'required|integer|min:1|max:12',
            'max_matriculados' => 'required|integer|min:1|max:100',
        ]);

        // Check if rule already exists
        $exists = ReglaPromocion::where('programa_estudio_id', $validated['programa_estudio_id'])
            ->where('turno_id', $validated['turno_id'])
            ->where('ciclo', $validated['ciclo'])
            ->exists();
        
        if ($exists) {
            return back()->withErrors(['ciclo' => 'Ya existe una regla para este programa, turno y ciclo.'])->withInput();
        }

        ReglaPromocion::create($validated);

        return redirect()->route('admin.reglas.index')
            ->with('success', 'Regla de promoción creada correctamente.');
    }

    public function edit(ReglaPromocion $regla)
    {
        $programas = ProgramaEstudio::activo()->get();
        $turnos = Turno::all();
        return view('admin.reglas.edit', compact('regla', 'programas', 'turnos'));
    }

    public function update(Request $request, ReglaPromocion $regla)
    {
        $validated = $request->validate([
            'programa_estudio_id' => 'required|exists:programas_estudio,id',
            'turno_id' => 'required|exists:turnos,id',
            'ciclo' => 'required|integer|min:1|max:12',
            'max_matriculados' => 'required|integer|min:1|max:100',
        ]);

        // Check if rule already exists for another record
        $exists = ReglaPromocion::where('programa_estudio_id', $validated['programa_estudio_id'])
            ->where('turno_id', $validated['turno_id'])
            ->where('ciclo', $validated['ciclo'])
            ->where('id', '!=', $regla->id)
            ->exists();
        
        if ($exists) {
            return back()->withErrors(['ciclo' => 'Ya existe una regla para este programa, turno y ciclo.'])->withInput();
        }

        $regla->update($validated);

        return redirect()->route('admin.reglas.index')
            ->with('success', 'Regla de promoción actualizada correctamente.');
    }

    public function destroy(ReglaPromocion $regla)
    {
        $regla->delete();

        return redirect()->route('admin.reglas.index')
            ->with('success', 'Regla de promoción eliminada correctamente.');
    }
}
