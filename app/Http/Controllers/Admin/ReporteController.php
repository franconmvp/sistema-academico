<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acta;
use App\Models\AsignacionDocente;
use App\Models\Matricula;
use App\Models\PeriodoLectivo;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        return view('admin.reportes.index');
    }

    public function matriculaSemestral(Request $request)
    {
        $periodoId = $request->get('periodo_id', PeriodoLectivo::activo()->first()?->id);
        
        $matriculas = Matricula::with([
            'estudiante.programaEstudio',
            'estudiante.turno',
            'periodoLectivo',
            'detalles.unidadDidactica',
        ])
            ->where('periodo_lectivo_id', $periodoId)
            ->where('estado', 'aprobada')
            ->orderBy('created_at')
            ->get();
        
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        
        // Group by programa
        $matriculasPorPrograma = $matriculas->groupBy('estudiante.programaEstudio.nombre');
        
        return view('admin.reportes.matricula-semestral', compact('matriculas', 'matriculasPorPrograma', 'periodos', 'periodoId'));
    }

    public function notasPorPeriodo(Request $request)
    {
        $periodoId = $request->get('periodo_id', PeriodoLectivo::activo()->first()?->id);
        
        $asignaciones = AsignacionDocente::with([
            'personal',
            'unidadDidactica.planEstudio.programaEstudio',
            'turno',
            'matriculaDetalles.matricula.estudiante',
            'matriculaDetalles.nota',
        ])
            ->where('periodo_lectivo_id', $periodoId)
            ->orderBy('unidad_didactica_id')
            ->get();
        
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        
        return view('admin.reportes.notas-periodo', compact('asignaciones', 'periodos', 'periodoId'));
    }

    public function actas(Request $request)
    {
        $periodoId = $request->get('periodo_id', PeriodoLectivo::activo()->first()?->id);
        
        $query = Acta::with([
            'asignacionDocente.personal',
            'asignacionDocente.unidadDidactica',
            'asignacionDocente.turno',
            'generadoPor',
        ]);
        
        if ($periodoId) {
            $query->whereHas('asignacionDocente', function ($q) use ($periodoId) {
                $q->where('periodo_lectivo_id', $periodoId);
            });
        }
        
        $actas = $query->orderBy('created_at', 'desc')->paginate(15);
        $periodos = PeriodoLectivo::orderBy('anio', 'desc')->orderBy('semestre', 'desc')->get();
        
        return view('admin.reportes.actas', compact('actas', 'periodos', 'periodoId'));
    }

    public function generarActa(AsignacionDocente $asignacion)
    {
        // Check if acta already exists
        $actaExistente = Acta::where('asignacion_docente_id', $asignacion->id)->first();
        
        if ($actaExistente) {
            return redirect()->route('admin.reportes.actas')
                ->with('error', 'Ya existe un acta para esta asignación.');
        }

        // Generate acta number
        $year = now()->year;
        $lastActa = Acta::where('numero_acta', 'like', "{$year}-%")
            ->orderBy('numero_acta', 'desc')
            ->first();
        
        $nextNumber = 1;
        if ($lastActa) {
            $parts = explode('-', $lastActa->numero_acta);
            $nextNumber = (int)end($parts) + 1;
        }
        
        $numeroActa = sprintf('%d-%05d', $year, $nextNumber);

        Acta::create([
            'asignacion_docente_id' => $asignacion->id,
            'numero_acta' => $numeroActa,
            'fecha_generacion' => now(),
            'estado' => 'generada',
            'generado_por' => auth()->id(),
        ]);

        return redirect()->route('admin.reportes.actas')
            ->with('success', 'Acta generada correctamente: ' . $numeroActa);
    }

    public function verActa(Acta $acta)
    {
        $acta->load([
            'asignacionDocente.personal',
            'asignacionDocente.unidadDidactica.planEstudio.programaEstudio',
            'asignacionDocente.periodoLectivo',
            'asignacionDocente.turno',
            'asignacionDocente.matriculaDetalles.matricula.estudiante',
            'asignacionDocente.matriculaDetalles.nota',
            'generadoPor',
        ]);
        
        return view('admin.reportes.ver-acta', compact('acta'));
    }
}
