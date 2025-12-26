<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonalController extends Controller
{
    public function index(Request $request)
    {
        $query = Personal::with('user');
        
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        $personal = $query->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->paginate(15);
            
        return view('admin.personal.index', compact('personal'));
    }

    public function create()
    {
        return view('admin.personal.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|string|size:8|unique:personal',
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'tipo' => 'required|in:docente,administrativo,jerarquico',
            'cargo' => 'nullable|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'grado_academico' => 'nullable|string|max:255',
            'titulo_profesional' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'fecha_ingreso' => 'nullable|date',
            'condicion' => 'required|in:nombrado,contratado',
            'email' => 'nullable|email|unique:users,email',
            'crear_cuenta' => 'boolean',
        ]);

        $userId = null;

        // Create user account if requested
        if ($request->has('crear_cuenta') && $request->filled('email')) {
            $user = User::create([
                'name' => $validated['nombres'] . ' ' . $validated['apellido_paterno'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['dni']), // Default password is DNI
                'role' => $validated['tipo'] === 'docente' ? 'docente' : 'admin',
                'is_active' => true,
            ]);
            $userId = $user->id;
        }

        Personal::create([
            'user_id' => $userId,
            'dni' => $validated['dni'],
            'nombres' => $validated['nombres'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'tipo' => $validated['tipo'],
            'cargo' => $validated['cargo'],
            'especialidad' => $validated['especialidad'],
            'grado_academico' => $validated['grado_academico'],
            'titulo_profesional' => $validated['titulo_profesional'],
            'telefono' => $validated['telefono'],
            'direccion' => $validated['direccion'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'sexo' => $validated['sexo'],
            'fecha_ingreso' => $validated['fecha_ingreso'],
            'condicion' => $validated['condicion'],
            'activo' => true,
        ]);

        return redirect()->route('admin.personal.index')
            ->with('success', 'Personal registrado correctamente.');
    }

    public function show(Personal $personal)
    {
        $personal->load(['user', 'asignacionesDocente.unidadDidactica', 'asignacionesDocente.periodoLectivo']);
        return view('admin.personal.show', compact('personal'));
    }

    public function edit(Personal $personal)
    {
        return view('admin.personal.edit', compact('personal'));
    }

    public function update(Request $request, Personal $personal)
    {
        $validated = $request->validate([
            'dni' => 'required|string|size:8|unique:personal,dni,' . $personal->id,
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'tipo' => 'required|in:docente,administrativo,jerarquico',
            'cargo' => 'nullable|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'grado_academico' => 'nullable|string|max:255',
            'titulo_profesional' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'fecha_ingreso' => 'nullable|date',
            'condicion' => 'required|in:nombrado,contratado',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        $personal->update($validated);

        // Update user name if exists
        if ($personal->user) {
            $personal->user->update([
                'name' => $validated['nombres'] . ' ' . $validated['apellido_paterno'],
            ]);
        }

        return redirect()->route('admin.personal.index')
            ->with('success', 'Personal actualizado correctamente.');
    }

    public function destroy(Personal $personal)
    {
        if ($personal->asignacionesDocente()->exists()) {
            return back()->with('error', 'No se puede eliminar porque tiene asignaciones docentes.');
        }

        if ($personal->user) {
            $personal->user->delete();
        }
        
        $personal->delete();

        return redirect()->route('admin.personal.index')
            ->with('success', 'Personal eliminado correctamente.');
    }
}
