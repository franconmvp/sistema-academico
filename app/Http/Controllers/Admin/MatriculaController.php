<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsignacionDocente;
use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\MatriculaDetalle;
use App\Models\Nota;
use App\Models\PeriodoLectivo;
use App\Models\ReglaPromocion;
use App\Models\UnidadDidactica;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index(Request $request)
    {
        $periodoActivo = PeriodoLectivo::activo()->first();
        $periodoId = $request->get('periodo_id', $periodoActivo?->id);
        
        $query = Matricula::with(['estudiante.programaEstudio', 'estudiante.turno', 'periodoLectivo'])
            ->where('periodo_lectivo_id', $periodoId);
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        $matriculas = $query->orderBy('created_at', 'desc')->paginate(15);
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        
        return view('admin.matriculas.index', compact('matriculas', 'periodos', 'periodoId'));
    }

    public function create()
    {
        $periodoActivo = PeriodoLectivo::activo()->first();
        $estudiantes = Estudiante::activo()
            ->with(['programaEstudio', 'turno'])
            ->orderBy('apellido_paterno')
            ->get();
        
        return view('admin.matriculas.create', compact('periodoActivo', 'estudiantes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'periodo_lectivo_id' => 'required|exists:periodos_lectivos,id',
            'ciclo' => 'required|integer|min:1|max:12',
            'tipo' => 'required|in:prematricula,matricula',
            'unidades' => 'required|array|min:1',
            'unidades.*' => 'exists:unidades_didacticas,id',
        ]);

        $estudiante = Estudiante::find($validated['estudiante_id']);
        
        // Check enrollment limit
        $regla = ReglaPromocion::where('programa_estudio_id', $estudiante->programa_estudio_id)
            ->where('turno_id', $estudiante->turno_id)
            ->where('ciclo', $validated['ciclo'])
            ->first();
        
        if ($regla) {
            $matriculadosActuales = Matricula::where('periodo_lectivo_id', $validated['periodo_lectivo_id'])
                ->where('ciclo', $validated['ciclo'])
                ->whereHas('estudiante', function ($q) use ($estudiante) {
                    $q->where('programa_estudio_id', $estudiante->programa_estudio_id)
                        ->where('turno_id', $estudiante->turno_id);
                })
                ->where('estado', 'aprobada')
                ->count();
            
            if ($matriculadosActuales >= $regla->max_matriculados) {
                return back()->with('error', 'Se ha alcanzado el límite de matriculados para este ciclo y turno.');
            }
        }

        // Check if already enrolled
        $existingMatricula = Matricula::where('estudiante_id', $validated['estudiante_id'])
            ->where('periodo_lectivo_id', $validated['periodo_lectivo_id'])
            ->first();
        
        if ($existingMatricula) {
            return back()->with('error', 'El estudiante ya tiene una matrícula para este período.');
        }

        // Create matricula
        $matricula = Matricula::create([
            'estudiante_id' => $validated['estudiante_id'],
            'periodo_lectivo_id' => $validated['periodo_lectivo_id'],
            'ciclo' => $validated['ciclo'],
            'tipo' => $validated['tipo'],
            'estado' => 'pendiente',
            'fecha_matricula' => now(),
        ]);

        // Create detalle for each unidad
        foreach ($validated['unidades'] as $unidadId) {
            $unidad = UnidadDidactica::find($unidadId);
            
            // Find docente assignment for this unidad
            $asignacion = AsignacionDocente::where('unidad_didactica_id', $unidadId)
                ->where('periodo_lectivo_id', $validated['periodo_lectivo_id'])
                ->where('turno_id', $estudiante->turno_id)
                ->first();
            
            // Count previous enrollments
            $numMatricula = MatriculaDetalle::whereHas('matricula', function ($q) use ($estudiante) {
                    $q->where('estudiante_id', $estudiante->id);
                })
                ->where('unidad_didactica_id', $unidadId)
                ->count() + 1;
            
            $detalle = MatriculaDetalle::create([
                'matricula_id' => $matricula->id,
                'unidad_didactica_id' => $unidadId,
                'asignacion_docente_id' => $asignacion?->id,
                'numero_matricula' => $numMatricula,
                'estado' => 'cursando',
            ]);

            // Create nota record
            Nota::create([
                'matricula_detalle_id' => $detalle->id,
                'estado' => 'pendiente',
            ]);
        }

        return redirect()->route('admin.matriculas.index')
            ->with('success', 'Matrícula registrada correctamente.');
    }

    public function show(Matricula $matricula)
    {
        $matricula->load([
            'estudiante.programaEstudio',
            'estudiante.turno',
            'periodoLectivo',
            'detalles.unidadDidactica',
            'detalles.asignacionDocente.personal',
            'detalles.nota',
        ]);
        
        return view('admin.matriculas.show', compact('matricula'));
    }

    public function aprobar(Matricula $matricula)
    {
        $matricula->update([
            'tipo' => 'matricula',
            'estado' => 'aprobada',
        ]);

        // Update student's current cycle
        $matricula->estudiante->update([
            'ciclo_actual' => $matricula->ciclo,
        ]);

        return redirect()->route('admin.matriculas.index')
            ->with('success', 'Matrícula aprobada correctamente.');
    }

    public function rechazar(Matricula $matricula)
    {
        $matricula->update(['estado' => 'rechazada']);

        return redirect()->route('admin.matriculas.index')
            ->with('success', 'Matrícula rechazada.');
    }

    public function getUnidades(Request $request)
    {
        $estudiante = Estudiante::find($request->estudiante_id);
        
        if (!$estudiante) {
            return response()->json([]);
        }
        
        $unidades = UnidadDidactica::where('plan_estudio_id', $estudiante->plan_estudio_id)
            ->where('ciclo', $request->ciclo)
            ->get(['id', 'codigo', 'nombre', 'creditos', 'horas_semanales']);
        
        return response()->json($unidades);
    }

    public function fichaMatricula(Matricula $matricula)
    {
        $matricula->load([
            'estudiante.programaEstudio',
            'estudiante.planEstudio',
            'estudiante.turno',
            'periodoLectivo',
            'detalles.unidadDidactica',
            'detalles.asignacionDocente.personal',
        ]);
        
        return view('admin.matriculas.ficha', compact('matricula'));
    }
}
