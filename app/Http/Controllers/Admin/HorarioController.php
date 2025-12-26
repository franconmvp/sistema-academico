<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsignacionDocente;
use App\Models\Horario;
use App\Models\PeriodoLectivo;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        $periodoActivo = PeriodoLectivo::activo()->first();
        $periodoId = $request->get('periodo_id', $periodoActivo?->id);
        
        $asignaciones = AsignacionDocente::with([
            'personal',
            'unidadDidactica',
            'turno',
            'horarios',
        ])
            ->where('periodo_lectivo_id', $periodoId)
            ->orderBy('personal_id')
            ->get();
        
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        
        return view('admin.horarios.index', compact('asignaciones', 'periodos', 'periodoId'));
    }

    public function edit(AsignacionDocente $asignacion)
    {
        $asignacion->load(['personal', 'unidadDidactica', 'turno', 'horarios']);
        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        
        return view('admin.horarios.edit', compact('asignacion', 'dias'));
    }

    public function update(Request $request, AsignacionDocente $asignacion)
    {
        $validated = $request->validate([
            'horarios' => 'array',
            'horarios.*.dia' => 'required|in:lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            'horarios.*.hora_inicio' => 'required|date_format:H:i',
            'horarios.*.hora_fin' => 'required|date_format:H:i|after:horarios.*.hora_inicio',
            'horarios.*.aula' => 'nullable|string|max:50',
        ]);

        // Delete existing horarios
        $asignacion->horarios()->delete();

        // Create new horarios
        if (isset($validated['horarios'])) {
            foreach ($validated['horarios'] as $horarioData) {
                $asignacion->horarios()->create($horarioData);
            }
        }

        return redirect()->route('admin.horarios.index')
            ->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('admin.horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }
}
