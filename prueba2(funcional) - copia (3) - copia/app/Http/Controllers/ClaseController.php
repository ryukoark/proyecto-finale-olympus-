<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin !== 1) {
            return redirect('/dashboard');
        }

        $clases = Clase::all();
        return view('clases.index', compact('clases'));
    }

    public function create()
    {
        if (Auth::user()->is_admin !== 1) {
            return redirect('/dashboard');
        }

        return view('clases.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->is_admin !== 1) {
            return redirect('/dashboard');
        }

        $validated = $request->validate([
            'categoria' => 'required|string|max:255',
            'instructor' => 'required|string|max:255',
            'cupos_totales' => 'required|integer',
            'duracion' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'costo_inscripcion' => 'required|numeric',
            'informacion' => 'required|string',
        ]);

        Clase::create($validated);
        return redirect()->route('clases.index')->with('success', 'Clase creada exitosamente.');
    }

    public function show(Clase $clase)
    {
        if (Auth::user()->is_admin !== 1) {
            return redirect('/dashboard');
        }

        return view('clases.show', compact('clase'));
    }

    public function edit(Clase $clase)
    {
        if (Auth::user()->is_admin !== 1) {
            return redirect('/dashboard');
        }

        return view('clases.edit', compact('clase'));
    }

    public function update(Request $request, $id)
{
    $clase = Clase::findOrFail($id);
    $clase->categoria = $request->input('categoria');
    $clase->instructor = $request->input('instructor');
    $clase->cupos_totales = $request->input('cupos_totales');
    $clase->duracion = $request->input('duracion');
    $clase->fecha_inicio = $request->input('fecha_inicio');
    $clase->hora_inicio = $request->input('hora_inicio');
    $clase->hora_fin = $request->input('hora_fin');
    $clase->costo_inscripcion = $request->input('costo_inscripcion');
    $clase->informacion = $request->input('informacion');
    $clase->save();

    return redirect()->route('clases.list')->with('success', 'Clase actualizada correctamente');
}
    public function destroy(Clase $clase)
    {
        if (Auth::user()->is_admin !== 1) {
            return redirect('/dashboard');
        }

        $clase->delete();
        return redirect()->route('clases.index')->with('success', 'Clase eliminada exitosamente.');
    }
    public function listarClases()
{
    $clases = Clase::all();
        return view('clases.list', compact('clases'));
}

}
