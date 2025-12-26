<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index()
    {
        $institution = Institution::first();
        return view('admin.institution.index', compact('institution'));
    }

    public function edit()
    {
        $institution = Institution::first() ?? new Institution();
        return view('admin.institution.edit', compact('institution'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'codigo_modular' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'tipo_ies' => 'nullable|string|max:255',
            'dre' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'correo' => 'nullable|email|max:255',
            'pagina_web' => 'nullable|url|max:255',
            'otros' => 'nullable|string',
        ]);

        $institution = Institution::first();
        
        if ($institution) {
            $institution->update($validated);
        } else {
            Institution::create($validated);
        }

        return redirect()->route('admin.institution.index')
            ->with('success', 'Información institucional actualizada correctamente.');
    }
}
