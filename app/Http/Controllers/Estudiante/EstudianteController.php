<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function miPerfil(Request $request)
    {
        $estudiante = $request->user()->estudiante;
        
        if (!$estudiante) {
            return redirect()->route('dashboard')
                ->with('error', 'No tiene perfil de estudiante asociado.');
        }
        
        $estudiante->load(['programaEstudio', 'planEstudio', 'turno']);
        
        return view('estudiante.mi-perfil', compact('estudiante'));
    }

    public function historialAcademico(Request $request)
    {
        $estudiante = $request->user()->estudiante;
        
        if (!$estudiante) {
            return redirect()->route('dashboard')
                ->with('error', 'No tiene perfil de estudiante asociado.');
        }
        
        $matriculas = $estudiante->matriculas()
            ->with([
                'periodoLectivo',
                'detalles.unidadDidactica',
                'detalles.asignacionDocente.personal',
                'detalles.nota',
            ])
            ->where('estado', 'aprobada')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate statistics
        $totalCreditos = 0;
        $creditosAprobados = 0;
        $sumaNotas = 0;
        $cantidadNotas = 0;
        
        foreach ($matriculas as $matricula) {
            foreach ($matricula->detalles as $detalle) {
                $creditos = $detalle->unidadDidactica->creditos;
                $totalCreditos += $creditos;
                
                if ($detalle->nota && $detalle->nota->estado === 'aprobado') {
                    $creditosAprobados += $creditos;
                    $sumaNotas += $detalle->nota->nota_definitiva;
                    $cantidadNotas++;
                }
            }
        }
        
        $promedioGeneral = $cantidadNotas > 0 ? round($sumaNotas / $cantidadNotas, 2) : 0;
        
        $estadisticas = [
            'total_creditos' => $totalCreditos,
            'creditos_aprobados' => $creditosAprobados,
            'promedio_general' => $promedioGeneral,
            'materias_cursadas' => $cantidadNotas,
        ];
        
        return view('estudiante.historial-academico', compact('estudiante', 'matriculas', 'estadisticas'));
    }

    public function misMatriculas(Request $request)
    {
        $estudiante = $request->user()->estudiante;
        
        if (!$estudiante) {
            return redirect()->route('dashboard')
                ->with('error', 'No tiene perfil de estudiante asociado.');
        }
        
        $matriculas = $estudiante->matriculas()
            ->with(['periodoLectivo', 'detalles.unidadDidactica'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('estudiante.mis-matriculas', compact('estudiante', 'matriculas'));
    }

    public function fichaMatricula(Request $request, $matriculaId)
    {
        $estudiante = $request->user()->estudiante;
        
        if (!$estudiante) {
            return redirect()->route('dashboard')
                ->with('error', 'No tiene perfil de estudiante asociado.');
        }
        
        $matricula = $estudiante->matriculas()
            ->with([
                'periodoLectivo',
                'detalles.unidadDidactica',
                'detalles.asignacionDocente.personal',
            ])
            ->findOrFail($matriculaId);
        
        $estudiante->load(['programaEstudio', 'planEstudio', 'turno']);
        
        return view('estudiante.ficha-matricula', compact('estudiante', 'matricula'));
    }

    public function misNotas(Request $request)
    {
        $estudiante = $request->user()->estudiante;
        
        if (!$estudiante) {
            return redirect()->route('dashboard')
                ->with('error', 'No tiene perfil de estudiante asociado.');
        }
        
        $matriculas = $estudiante->matriculas()
            ->with([
                'periodoLectivo',
                'detalles.unidadDidactica',
                'detalles.nota',
            ])
            ->where('estado', 'aprobada')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('estudiante.mis-notas', compact('estudiante', 'matriculas'));
    }

    public function miHorario(Request $request)
    {
        $estudiante = $request->user()->estudiante;
        
        if (!$estudiante) {
            return redirect()->route('dashboard')
                ->with('error', 'No tiene perfil de estudiante asociado.');
        }
        
        // Get current period enrollment
        $matriculaActual = $estudiante->matriculas()
            ->whereHas('periodoLectivo', function ($q) {
                $q->where('activo', true);
            })
            ->with([
                'detalles.asignacionDocente.horarios',
                'detalles.unidadDidactica',
            ])
            ->where('estado', 'aprobada')
            ->first();
        
        // Organize by day
        $horarioPorDia = [
            'lunes' => [],
            'martes' => [],
            'miercoles' => [],
            'jueves' => [],
            'viernes' => [],
            'sabado' => [],
        ];
        
        if ($matriculaActual) {
            foreach ($matriculaActual->detalles as $detalle) {
                if ($detalle->asignacionDocente) {
                    foreach ($detalle->asignacionDocente->horarios as $horario) {
                        $horarioPorDia[$horario->dia][] = [
                            'hora_inicio' => $horario->hora_inicio,
                            'hora_fin' => $horario->hora_fin,
                            'unidad' => $detalle->unidadDidactica->nombre,
                            'aula' => $horario->aula ?? $detalle->asignacionDocente->aula,
                        ];
                    }
                }
            }
        }
        
        // Sort by time
        foreach ($horarioPorDia as $dia => &$horarios) {
            usort($horarios, fn($a, $b) => $a['hora_inicio'] <=> $b['hora_inicio']);
        }
        
        return view('estudiante.mi-horario', compact('estudiante', 'horarioPorDia', 'matriculaActual'));
    }
}
