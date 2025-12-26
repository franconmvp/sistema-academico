<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,docente,estudiante',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
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
            'role' => 'required|in:admin,docente,estudiante',
            'is_active' => 'boolean',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

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
