<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsignacionDocente;
use App\Models\PeriodoLectivo;
use App\Models\Personal;
use App\Models\Turno;
use App\Models\UnidadDidactica;
use Illuminate\Http\Request;

class AsignacionDocenteController extends Controller
{
    public function index(Request $request)
    {
        $query = AsignacionDocente::with([
            'personal',
            'unidadDidactica.planEstudio.programaEstudio',
            'periodoLectivo',
            'turno',
        ]);
        
        if ($request->filled('periodo_id')) {
            $query->where('periodo_lectivo_id', $request->periodo_id);
        } else {
            // Default to active period
            $periodoActivo = PeriodoLectivo::activo()->first();
            if ($periodoActivo) {
                $query->where('periodo_lectivo_id', $periodoActivo->id);
            }
        }
        
        $asignaciones = $query->orderBy('personal_id')->paginate(15);
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        
        return view('admin.asignaciones.index', compact('asignaciones', 'periodos'));
    }

    public function create()
    {
        $docentes = Personal::docentes()->activo()->orderBy('apellido_paterno')->get();
        $unidades = UnidadDidactica::with('planEstudio.programaEstudio')->orderBy('nombre')->get();
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        $turnos = Turno::all();
        
        return view('admin.asignaciones.create', compact('docentes', 'unidades', 'periodos', 'turnos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'personal_id' => 'required|exists:personal,id',
            'unidad_didactica_id' => 'required|exists:unidades_didacticas,id',
            'periodo_lectivo_id' => 'required|exists:periodos_lectivos,id',
            'turno_id' => 'required|exists:turnos,id',
            'aula' => 'nullable|string|max:50',
        ]);

        // Check if assignment already exists
        $exists = AsignacionDocente::where('unidad_didactica_id', $validated['unidad_didactica_id'])
            ->where('periodo_lectivo_id', $validated['periodo_lectivo_id'])
            ->where('turno_id', $validated['turno_id'])
            ->exists();
        
        if ($exists) {
            return back()->withErrors(['unidad_didactica_id' => 'Esta unidad didáctica ya tiene un docente asignado para este período y turno.'])->withInput();
        }

        AsignacionDocente::create($validated);

        return redirect()->route('admin.asignaciones.index')
            ->with('success', 'Asignación docente creada correctamente.');
    }

    public function edit(AsignacionDocente $asignacion)
    {
        $docentes = Personal::docentes()->activo()->orderBy('apellido_paterno')->get();
        $unidades = UnidadDidactica::with('planEstudio.programaEstudio')->orderBy('nombre')->get();
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        $turnos = Turno::all();
        
        return view('admin.asignaciones.edit', compact('asignacion', 'docentes', 'unidades', 'periodos', 'turnos'));
    }

    public function update(Request $request, AsignacionDocente $asignacion)
    {
        $validated = $request->validate([
            'personal_id' => 'required|exists:personal,id',
            'unidad_didactica_id' => 'required|exists:unidades_didacticas,id',
            'periodo_lectivo_id' => 'required|exists:periodos_lectivos,id',
            'turno_id' => 'required|exists:turnos,id',
            'aula' => 'nullable|string|max:50',
        ]);

        // Check if assignment already exists for another record
        $exists = AsignacionDocente::where('unidad_didactica_id', $validated['unidad_didactica_id'])
            ->where('periodo_lectivo_id', $validated['periodo_lectivo_id'])
            ->where('turno_id', $validated['turno_id'])
            ->where('id', '!=', $asignacion->id)
            ->exists();
        
        if ($exists) {
            return back()->withErrors(['unidad_didactica_id' => 'Esta unidad didáctica ya tiene un docente asignado para este período y turno.'])->withInput();
        }

        $asignacion->update($validated);

        return redirect()->route('admin.asignaciones.index')
            ->with('success', 'Asignación docente actualizada correctamente.');
    }

    public function destroy(AsignacionDocente $asignacion)
    {
        if ($asignacion->matriculaDetalles()->exists()) {
            return back()->with('error', 'No se puede eliminar porque hay estudiantes matriculados.');
        }

        $asignacion->delete();

        return redirect()->route('admin.asignaciones.index')
            ->with('success', 'Asignación docente eliminada correctamente.');
    }
}
