<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificado;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class CertificadoController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificado::with(['estudiante', 'emitidoPor']);
        
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('estudiante', function ($q) use ($search) {
                $q->where('codigo_estudiante', 'like', "%{$search}%")
                    ->orWhere('nombres', 'like', "%{$search}%")
                    ->orWhere('apellido_paterno', 'like', "%{$search}%");
            });
        }
        
        $certificados = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.certificados.index', compact('certificados'));
    }

    public function create()
    {
        $estudiantes = Estudiante::with('programaEstudio')
            ->orderBy('apellido_paterno')
            ->get();
        
        return view('admin.certificados.create', compact('estudiantes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'tipo' => 'required|in:certificado_estudios,certificado_modular,grado,titulo',
            'descripcion' => 'nullable|string',
        ]);

        // Generate document number
        $year = now()->year;
        $tipo = strtoupper(substr($validated['tipo'], 0, 3));
        $lastDoc = Certificado::where('numero_documento', 'like', "{$tipo}-{$year}-%")
            ->orderBy('numero_documento', 'desc')
            ->first();
        
        $nextNumber = 1;
        if ($lastDoc) {
            $parts = explode('-', $lastDoc->numero_documento);
            $nextNumber = (int)end($parts) + 1;
        }
        
        $numeroDocumento = sprintf('%s-%d-%05d', $tipo, $year, $nextNumber);

        Certificado::create([
            'estudiante_id' => $validated['estudiante_id'],
            'tipo' => $validated['tipo'],
            'numero_documento' => $numeroDocumento,
            'fecha_emision' => now(),
            'descripcion' => $validated['descripcion'],
            'estado' => 'emitido',
            'emitido_por' => auth()->id(),
        ]);

        return redirect()->route('admin.certificados.index')
            ->with('success', 'Certificado emitido correctamente: ' . $numeroDocumento);
    }

    public function show(Certificado $certificado)
    {
        $certificado->load([
            'estudiante.programaEstudio',
            'estudiante.planEstudio',
            'estudiante.matriculas.periodoLectivo',
            'estudiante.matriculas.detalles.unidadDidactica',
            'estudiante.matriculas.detalles.nota',
            'emitidoPor',
        ]);
        
        return view('admin.certificados.show', compact('certificado'));
    }

    public function marcarEntregado(Certificado $certificado)
    {
        $certificado->update(['estado' => 'entregado']);

        return redirect()->route('admin.certificados.index')
            ->with('success', 'Certificado marcado como entregado.');
    }

    public function anular(Certificado $certificado)
    {
        $certificado->update(['estado' => 'anulado']);

        return redirect()->route('admin.certificados.index')
            ->with('success', 'Certificado anulado.');
    }
}
