<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    public function inscribir(Request $request, Clase $clase)
    {
        if ($clase->inscripciones()->count() >= $clase->cupos_totales) {
            return redirect()->route('clases.show', $clase)->with('error', 'No hay cupos disponibles.');
        }

        Inscripcion::create([
            'clase_id' => $clase->id,
            'user_id' => Auth::id(),
            'cupos' => $clase->inscripciones()->count() + 1,
            'cupos_totales' => $clase->cupos_totales,
        ]);

        return redirect()->route('clases.show', $clase)->with('success', 'Inscripción realizada con éxito.');
    }

    public function show(Clase $clase)
    {
        $hayCuposDisponibles = $clase->inscripciones()->count() < $clase->cupos_totales;
        return view('inscripciones.show', compact('clase', 'hayCuposDisponibles'));
    }
    public function misClases()
    {
        $user = Auth::user();
        $clases = $user->clases; // Corrigiendo el método para obtener las clases

        return view('inscripciones.mis_clases', compact('clases'));
    }
    
}
