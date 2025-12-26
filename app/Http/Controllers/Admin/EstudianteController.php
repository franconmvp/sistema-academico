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
            'email' => 'nullable|email|unique:users,email',
            'crear_cuenta' => 'boolean',
        ]);

        // Generate student code automatically: YYYY + Program code + sequential number
        $programa = ProgramaEstudio::find($validated['programa_estudio_id']);
        $year = date('Y');
        $prefix = $year . $programa->codigo;
        
        $lastStudent = Estudiante::where('codigo_estudiante', 'like', $prefix . '%')
            ->orderBy('codigo_estudiante', 'desc')
            ->first();
        
        if ($lastStudent) {
            $lastNumber = (int) substr($lastStudent->codigo_estudiante, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $codigoEstudiante = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        $userId = null;

        // Create user account if requested
        if ($request->has('crear_cuenta') && $request->filled('email')) {
            $user = User::create([
                'name' => $validated['nombres'] . ' ' . $validated['apellido_paterno'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['dni']), // Default password is DNI
                'role' => 'estudiante',
                'is_active' => true,
            ]);
            $userId = $user->id;
        }

        Estudiante::create([
            'user_id' => $userId,
            'programa_estudio_id' => $validated['programa_estudio_id'],
            'plan_estudio_id' => $validated['plan_estudio_id'],
            'turno_id' => $validated['turno_id'],
            'codigo_estudiante' => $codigoEstudiante,
            'dni' => $validated['dni'],
            'nombres' => $validated['nombres'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
            'sexo' => $validated['sexo'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'email_personal' => $validated['email_personal'] ?? null,
            'fecha_ingreso' => $validated['fecha_ingreso'],
            'ciclo_actual' => 1,
            'estado' => 'activo',
        ]);

        $message = 'Estudiante registrado correctamente. Código: ' . $codigoEstudiante;
        if ($userId) {
            $message .= ' - La contraseña inicial es su DNI.';
        }

        return redirect()->route('admin.estudiantes.index')
            ->with('success', $message);
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
        $emailRule = 'nullable|email';
        if (!$estudiante->user_id) {
            $emailRule .= '|unique:users,email';
        } else {
            $emailRule .= '|unique:users,email,' . $estudiante->user_id;
        }

        $validated = $request->validate([
            'programa_estudio_id' => 'required|exists:programas_estudio,id',
            'plan_estudio_id' => 'required|exists:planes_estudio,id',
            'turno_id' => 'required|exists:turnos,id',
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
            'email' => $emailRule,
            'crear_cuenta' => 'boolean',
        ]);

        $estudiante->update([
            'programa_estudio_id' => $validated['programa_estudio_id'],
            'plan_estudio_id' => $validated['plan_estudio_id'],
            'turno_id' => $validated['turno_id'],
            'dni' => $validated['dni'],
            'nombres' => $validated['nombres'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
            'sexo' => $validated['sexo'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'email_personal' => $validated['email_personal'] ?? null,
            'ciclo_actual' => $validated['ciclo_actual'],
            'estado' => $validated['estado'],
        ]);

        // Handle user account
        if ($estudiante->user) {
            // Update existing user
            $updateData = ['name' => $validated['nombres'] . ' ' . $validated['apellido_paterno']];
            if ($request->filled('email')) {
                $updateData['email'] = $validated['email'];
            }
            $estudiante->user->update($updateData);
        } elseif ($request->has('crear_cuenta') && $request->filled('email')) {
            // Create new user account
            $user = User::create([
                'name' => $validated['nombres'] . ' ' . $validated['apellido_paterno'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['dni']),
                'role' => 'estudiante',
                'is_active' => true,
            ]);
            $estudiante->update(['user_id' => $user->id]);
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
