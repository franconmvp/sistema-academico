<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Turno;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
    {
        $turnos = Turno::paginate(10);
        return view('admin.turnos.index', compact('turnos'));
    }

    public function create()
    {
        return view('admin.turnos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:turnos',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
        ]);

        Turno::create($validated);

        return redirect()->route('admin.turnos.index')
            ->with('success', 'Turno creado correctamente.');
    }

    public function edit(Turno $turno)
    {
        return view('admin.turnos.edit', compact('turno'));
    }

    public function update(Request $request, Turno $turno)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:turnos,nombre,' . $turno->id,
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
        ]);

        $turno->update($validated);

        return redirect()->route('admin.turnos.index')
            ->with('success', 'Turno actualizado correctamente.');
    }

    public function destroy(Turno $turno)
    {
        if ($turno->estudiantes()->exists()) {
            return back()->with('error', 'No se puede eliminar el turno porque tiene estudiantes asignados.');
        }

        $turno->delete();

        return redirect()->route('admin.turnos.index')
            ->with('success', 'Turno eliminado correctamente.');
    }
}
