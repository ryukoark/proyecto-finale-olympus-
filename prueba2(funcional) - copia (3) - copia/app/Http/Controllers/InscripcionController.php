<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Inscripcion;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    public function inscribir(Request $request, Clase $clase)
    {
        if ($clase->inscripciones()->count() >= $clase->cupos_totales) {
            return redirect()->route('clases.show', $clase)->with('error', 'No hay cupos disponibles.');
        }

        $request->validate([
            'imagen_pago' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagenPago = $request->file('imagen_pago');
        $timestamp = now()->format('YmdHis');
        $uniqueName = $timestamp . '_' . uniqid() . '.' . $imagenPago->getClientOriginalExtension();
        $imagenPagoPath = 'pagos/' . $uniqueName;
        $imagenPago->move(public_path('pagos'), $uniqueName);

        Inscripcion::create([
            'clase_id' => $clase->id,
            'user_id' => Auth::id(),
            'cupos' => $clase->inscripciones()->count() + 1,
            'cupos_totales' => $clase->cupos_totales,
        ]);

        Factura::create([
            'user_id' => Auth::id(),
            'tipo_factura' => 2, // 2 para inscripciones
            'monto' => $clase->costo_inscripcion,
            'imagen_pago' => $imagenPagoPath,
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
        $clases = $user->clases; 

        return view('inscripciones.mis_clases', compact('clases'));
    }
}
