<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\AsignacionDocente;
use App\Models\MatriculaDetalle;
use App\Models\Nota;
use App\Models\PeriodoLectivo;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function misAsignaciones(Request $request)
    {
        $personal = $request->user()->personal;
        
        if (!$personal) {
            return redirect()->route('dashboard')
                ->with('error', 'No tiene perfil de docente asociado.');
        }
        
        $periodoActivo = PeriodoLectivo::activo()->first();
        $periodoId = $request->get('periodo_id', $periodoActivo?->id);
        
        $asignaciones = $personal->asignacionesDocente()
            ->with(['unidadDidactica.planEstudio.programaEstudio', 'turno', 'horarios', 'periodoLectivo'])
            ->where('periodo_lectivo_id', $periodoId)
            ->get();
        
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        
        return view('docente.asignaciones', compact('asignaciones', 'periodos', 'periodoId', 'personal'));
    }

    public function listaEstudiantes(AsignacionDocente $asignacion)
    {
        // Verify docente owns this assignment
        if ($asignacion->personal_id !== auth()->user()->personal?->id) {
            abort(403);
        }
        
        $asignacion->load([
            'unidadDidactica.planEstudio.programaEstudio',
            'periodoLectivo',
            'turno',
            'matriculaDetalles.matricula.estudiante',
            'matriculaDetalles.nota',
        ]);
        
        // Filter only approved matriculas
        $estudiantes = $asignacion->matriculaDetalles()
            ->whereHas('matricula', function ($q) {
                $q->where('estado', 'aprobada');
            })
            ->with(['matricula.estudiante', 'nota'])
            ->get();
        
        return view('docente.lista-estudiantes', compact('asignacion', 'estudiantes'));
    }

    public function registrarNotas(AsignacionDocente $asignacion)
    {
        // Verify docente owns this assignment
        if ($asignacion->personal_id !== auth()->user()->personal?->id) {
            abort(403);
        }
        
        $asignacion->load([
            'unidadDidactica',
            'periodoLectivo',
            'turno',
        ]);
        
        $estudiantes = $asignacion->matriculaDetalles()
            ->whereHas('matricula', function ($q) {
                $q->where('estado', 'aprobada');
            })
            ->with(['matricula.estudiante', 'nota'])
            ->get();
        
        return view('docente.registrar-notas', compact('asignacion', 'estudiantes'));
    }

    public function guardarNotas(Request $request, AsignacionDocente $asignacion)
    {
        // Verify docente owns this assignment
        if ($asignacion->personal_id !== auth()->user()->personal?->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'notas' => 'required|array',
            'notas.*.matricula_detalle_id' => 'required|exists:matricula_detalle,id',
            'notas.*.nota_1' => 'nullable|numeric|min:0|max:20',
            'notas.*.nota_2' => 'nullable|numeric|min:0|max:20',
            'notas.*.nota_3' => 'nullable|numeric|min:0|max:20',
            'notas.*.nota_4' => 'nullable|numeric|min:0|max:20',
            'notas.*.examen_final' => 'nullable|numeric|min:0|max:20',
            'notas.*.nota_recuperacion' => 'nullable|numeric|min:0|max:20',
            'notas.*.observaciones' => 'nullable|string|max:255',
        ]);
        
        foreach ($validated['notas'] as $notaData) {
            $matriculaDetalle = MatriculaDetalle::find($notaData['matricula_detalle_id']);
            
            // Verify this detail belongs to this assignment
            if ($matriculaDetalle->asignacion_docente_id !== $asignacion->id) {
                continue;
            }
            
            $nota = $matriculaDetalle->nota;
            
            if (!$nota) {
                $nota = new Nota(['matricula_detalle_id' => $matriculaDetalle->id]);
            }
            
            $nota->nota_1 = $notaData['nota_1'] ?? null;
            $nota->nota_2 = $notaData['nota_2'] ?? null;
            $nota->nota_3 = $notaData['nota_3'] ?? null;
            $nota->nota_4 = $notaData['nota_4'] ?? null;
            $nota->examen_final = $notaData['examen_final'] ?? null;
            $nota->nota_recuperacion = $notaData['nota_recuperacion'] ?? null;
            $nota->observaciones = $notaData['observaciones'] ?? null;
            
            // Calculate averages
            $nota->promedio_parcial = $nota->calcularPromedioParcial();
            $nota->promedio_final = $nota->calcularPromedioFinal();
            $nota->nota_definitiva = $nota->calcularNotaDefinitiva();
            $nota->actualizarEstado();
            
            $nota->save();
            
            // Update matricula detalle estado
            if ($nota->estado === 'aprobado') {
                $matriculaDetalle->update(['estado' => 'aprobado']);
            } elseif ($nota->estado === 'desaprobado') {
                $matriculaDetalle->update(['estado' => 'desaprobado']);
            }
        }
        
        return redirect()->route('docente.lista-estudiantes', $asignacion)
            ->with('success', 'Notas guardadas correctamente.');
    }

    public function miHorario(Request $request)
    {
        $personal = $request->user()->personal;
        
        if (!$personal) {
            return redirect()->route('dashboard')
                ->with('error', 'No tiene perfil de docente asociado.');
        }
        
        $periodoActivo = PeriodoLectivo::activo()->first();
        $periodoId = $request->get('periodo_id', $periodoActivo?->id);
        
        $asignaciones = $personal->asignacionesDocente()
            ->with(['unidadDidactica', 'turno', 'horarios'])
            ->where('periodo_lectivo_id', $periodoId)
            ->get();
        
        // Organize by day
        $horarioPorDia = [
            'lunes' => [],
            'martes' => [],
            'miercoles' => [],
            'jueves' => [],
            'viernes' => [],
            'sabado' => [],
        ];
        
        foreach ($asignaciones as $asignacion) {
            foreach ($asignacion->horarios as $horario) {
                $horarioPorDia[$horario->dia][] = [
                    'hora_inicio' => $horario->hora_inicio,
                    'hora_fin' => $horario->hora_fin,
                    'unidad' => $asignacion->unidadDidactica->nombre,
                    'aula' => $horario->aula ?? $asignacion->aula,
                ];
            }
        }
        
        // Sort by time
        foreach ($horarioPorDia as $dia => &$horarios) {
            usort($horarios, fn($a, $b) => $a['hora_inicio'] <=> $b['hora_inicio']);
        }
        
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        
        return view('docente.mi-horario', compact('horarioPorDia', 'periodos', 'periodoId', 'personal'));
    }

    public function reporteNotas(AsignacionDocente $asignacion)
    {
        // Verify docente owns this assignment
        if ($asignacion->personal_id !== auth()->user()->personal?->id) {
            abort(403);
        }
        
        $asignacion->load([
            'unidadDidactica.planEstudio.programaEstudio',
            'periodoLectivo',
            'turno',
            'matriculaDetalles.matricula.estudiante',
            'matriculaDetalles.nota',
        ]);
        
        $estudiantes = $asignacion->matriculaDetalles()
            ->whereHas('matricula', function ($q) {
                $q->where('estado', 'aprobada');
            })
            ->with(['matricula.estudiante', 'nota'])
            ->get()
            ->sortBy('matricula.estudiante.apellido_paterno');
        
        return view('docente.reporte-notas', compact('asignacion', 'estudiantes'));
    }
}
