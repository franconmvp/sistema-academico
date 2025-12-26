<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\PlanEstudio;
use App\Models\ProgramaEstudio;
use App\Models\Turno;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    public function index(Request $request)
    {
        $query = Estudiante::with(['programaEstudio', 'turno', 'user']);
        
        if ($request->filled('programa_id')) {
            $query->where('programa_estudio_id', $request->programa_id);
        }
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('codigo_estudiante', 'like', "%{$search}%")
                    ->orWhere('dni', 'like', "%{$search}%")
                    ->orWhere('nombres', 'like', "%{$search}%")
                    ->orWhere('apellido_paterno', 'like', "%{$search}%")
                    ->orWhere('apellido_materno', 'like', "%{$search}%");
            });
        }
        
        $estudiantes = $query->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->paginate(15);
            
        $programas = ProgramaEstudio::activo()->get();
            
        return view('admin.estudiantes.index', compact('estudiantes', 'programas'));
    }

    public function create()
    {
        $programas = ProgramaEstudio::activo()->get();
        $turnos = Turno::all();
        return view('admin.estudiantes.create', compact('programas', 'turnos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'programa_estudio_id' => 'required|exists:programas_estudio,id',
            'plan_estudio_id' => 'required|exists:planes_estudio,id',
            'turno_id' => 'required|exists:turnos,id',
            'codigo_estudiante' => 'required|string|max:20|unique:estudiantes',
            'dni' => 'required|string|size:8|unique:estudiantes',
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'email_personal' => 'nullable|email|max:255',
            'fecha_ingreso' => 'required|date',
            'email' => 'required|email|unique:users,email',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['nombres'] . ' ' . $validated['apellido_paterno'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['dni']), // Default password is DNI
            'role' => 'estudiante',
            'is_active' => true,
        ]);

        Estudiante::create([
            'user_id' => $user->id,
            'programa_estudio_id' => $validated['programa_estudio_id'],
            'plan_estudio_id' => $validated['plan_estudio_id'],
            'turno_id' => $validated['turno_id'],
            'codigo_estudiante' => $validated['codigo_estudiante'],
            'dni' => $validated['dni'],
            'nombres' => $validated['nombres'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'sexo' => $validated['sexo'],
            'telefono' => $validated['telefono'],
            'direccion' => $validated['direccion'],
            'email_personal' => $validated['email_personal'],
            'fecha_ingreso' => $validated['fecha_ingreso'],
            'ciclo_actual' => 1,
            'estado' => 'activo',
        ]);

        return redirect()->route('admin.estudiantes.index')
            ->with('success', 'Estudiante registrado correctamente. La contraseña inicial es su DNI.');
    }

    public function show(Estudiante $estudiante)
    {
        $estudiante->load([
            'programaEstudio',
            'planEstudio',
            'turno',
            'user',
            'matriculas.periodoLectivo',
            'matriculas.detalles.unidadDidactica',
            'matriculas.detalles.nota',
        ]);
        return view('admin.estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante)
    {
        $programas = ProgramaEstudio::activo()->get();
        $planes = PlanEstudio::where('programa_estudio_id', $estudiante->programa_estudio_id)->vigente()->get();
        $turnos = Turno::all();
        return view('admin.estudiantes.edit', compact('estudiante', 'programas', 'planes', 'turnos'));
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        $validated = $request->validate([
            'programa_estudio_id' => 'required|exists:programas_estudio,id',
            'plan_estudio_id' => 'required|exists:planes_estudio,id',
            'turno_id' => 'required|exists:turnos,id',
            'codigo_estudiante' => 'required|string|max:20|unique:estudiantes,codigo_estudiante,' . $estudiante->id,
            'dni' => 'required|string|size:8|unique:estudiantes,dni,' . $estudiante->id,
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'email_personal' => 'nullable|email|max:255',
            'ciclo_actual' => 'required|integer|min:1|max:12',
            'estado' => 'required|in:activo,egresado,retirado,suspendido',
        ]);

        $estudiante->update($validated);

        // Update user name if exists
        if ($estudiante->user) {
            $estudiante->user->update([
                'name' => $validated['nombres'] . ' ' . $validated['apellido_paterno'],
            ]);
        }

        return redirect()->route('admin.estudiantes.index')
            ->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy(Estudiante $estudiante)
    {
        if ($estudiante->matriculas()->exists()) {
            return back()->with('error', 'No se puede eliminar porque tiene matrículas registradas.');
        }

        if ($estudiante->user) {
            $estudiante->user->delete();
        }
        
        $estudiante->delete();

        return redirect()->route('admin.estudiantes.index')
            ->with('success', 'Estudiante eliminado correctamente.');
    }

    public function getPlanes(Request $request)
    {
        $planes = PlanEstudio::where('programa_estudio_id', $request->programa_id)
            ->vigente()
            ->get(['id', 'codigo', 'nombre']);
        return response()->json($planes);
    }
}
