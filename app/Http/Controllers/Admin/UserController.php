<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('name')->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Get personnel without user accounts
        $personal = Personal::whereNull('user_id')
            ->where('activo', true)
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->get();
        
        return view('admin.users.create', compact('personal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'personal_id' => 'required|exists:personal,id',
            'email' => 'required|email|unique:users,email',
        ]);

        $personal = Personal::findOrFail($validated['personal_id']);

        // Determine role based on personnel type
        $role = $personal->tipo === 'docente' ? 'docente' : 'admin';

        // Create user with DNI as password
        $user = User::create([
            'name' => $personal->nombre_completo,
            'email' => $validated['email'],
            'password' => Hash::make($personal->dni),
            'role' => $role,
            'is_active' => true,
        ]);

        // Link user to personnel
        $personal->update(['user_id' => $user->id]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente. Rol: ' . ucfirst($role) . '. Contraseña: DNI del personal.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puede eliminarse a sí mismo.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puede desactivarse a sí mismo.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Estado del usuario actualizado.');
    }

    public function resetPassword(User $user)
    {
        // Reset password to DNI if estudiante or docente
        if ($user->estudiante) {
            $user->update(['password' => Hash::make($user->estudiante->dni)]);
        } elseif ($user->personal) {
            $user->update(['password' => Hash::make($user->personal->dni)]);
        } else {
            $user->update(['password' => Hash::make('password123')]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Contraseña reseteada correctamente.');
    }
}
