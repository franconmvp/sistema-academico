<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\PeriodoLectivo;
use App\Models\Personal;
use App\Models\ProgramaEstudio;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isDocente()) {
            return $this->docenteDashboard($user);
        } else {
            return $this->estudianteDashboard($user);
        }
    }

    protected function adminDashboard()
    {
        $stats = [
            'total_estudiantes' => Estudiante::activo()->count(),
            'total_docentes' => Personal::docentes()->activo()->count(),
            'total_programas' => ProgramaEstudio::activo()->count(),
            'periodo_activo' => PeriodoLectivo::activo()->first(),
            'matriculas_pendientes' => Matricula::where('estado', 'pendiente')->count(),
        ];

        $ultimasMatriculas = Matricula::with(['estudiante', 'periodoLectivo'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ultimasMatriculas'));
    }

    protected function docenteDashboard($user)
    {
        $personal = $user->personal;
        $periodoActivo = PeriodoLectivo::activo()->first();
        
        $asignaciones = [];
        if ($personal && $periodoActivo) {
            $asignaciones = $personal->asignacionesDocente()
                ->where('periodo_lectivo_id', $periodoActivo->id)
                ->with(['unidadDidactica', 'turno', 'horarios'])
                ->get();
        }

        return view('docente.dashboard', compact('personal', 'periodoActivo', 'asignaciones'));
    }

    protected function estudianteDashboard($user)
    {
        $estudiante = $user->estudiante;
        $periodoActivo = PeriodoLectivo::activo()->first();
        
        $matriculaActual = null;
        $historialNotas = collect();
        
        if ($estudiante) {
            $matriculaActual = $estudiante->matriculas()
                ->where('periodo_lectivo_id', $periodoActivo?->id)
                ->with(['detalles.unidadDidactica', 'detalles.nota'])
                ->first();
            
            $historialNotas = $estudiante->matriculas()
                ->with(['periodoLectivo', 'detalles.unidadDidactica', 'detalles.nota'])
                ->where('estado', 'aprobada')
                ->get();
        }

        return view('estudiante.dashboard', compact('estudiante', 'periodoActivo', 'matriculaActual', 'historialNotas'));
    }
}
