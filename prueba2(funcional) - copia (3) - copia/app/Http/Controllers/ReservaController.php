<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Cancha; // Importar el modelo Cancha

class ReservaController extends Controller
{
    public function seleccionarCancha()
    {
        $canchas = Cancha::all(); // Obtener todas las canchas
        return view('cancha_seleccion', compact('canchas')); // Pasar las canchas a la vista
    }

    public function index($cancha)
    {
        $user = Auth::user();
        $cancha = Cancha::find($cancha); // Obtener la cancha por ID
        return view('reservar', compact('cancha', 'user'));
    }

    public function store(Request $request, $cancha)
{
    // Validación de los datos
    $validator = Validator::make($request->all(), [
        'fecha' => 'required|date',
        'horarios' => 'required|array',
        'horarios.*' => 'required|string',
    ]);

    // Manejar errores de validación
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Verificar que la cancha exista
    $cancha = Cancha::find($cancha);
    if (!$cancha) {
        return redirect()->back()->with('error', 'Cancha no encontrada.');
    }

    // Crear las reservas en el array
    $reservas = [];
    foreach ($request->horarios as $horario) {
        $reservas[] = [
            'cancha_id' => $cancha->id,
            'fecha' => $request->fecha,
            'horario' => $horario,
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Insertar las reservas en la base de datos
    Reserva::insert($reservas);

    // Redirigir con un mensaje de éxito
    return redirect()->route('dashboard')->with('success', 'Reservas realizadas exitosamente');
}


public function resumen(Request $request)
{
    $fecha = $request->input('fecha');
    $horarios = $request->input('horarios');
    $canchaId = $request->input('cancha'); // Asegúrate de que estamos recibiendo el ID de la cancha.

    // Calcular el monto basado en los horarios
    $monto = 0;
    foreach ($horarios as $horario) {
        // Definir la tarifa de las horas
        $tarifa = 10; // Tarifa estándar

        // Verificar si el horario es a partir de las 6:00 pm
        if (strpos($horario, '6:00') !== false || strpos($horario, '7:00') !== false || strpos($horario, '8:00') !== false) {
            $tarifa = 15; // Tarifa después de las 6:00 pm
        }

        $monto += $tarifa;
    }

    return view('resumen', compact('fecha', 'horarios', 'monto', 'canchaId'));
}


    public function getHorarios(Request $request, $cancha)
    {
        $fecha = $request->input('fecha');

        $horarios = [
            '10:00 a 11:00',
            '11:00 a 12:00',
            '12:00 a 1:00',
            '1:00 a 2:00',
            '2:00 a 3:00',
            '3:00 a 4:00',
            '4:00 a 5:00',
            '6:00 a 7:00',
            '7:00 a 8:00',
            '8:00 a 9:00',
        ];

        $reservas = Reserva::where('cancha_id', $cancha)->where('fecha', $fecha)->pluck('horario')->toArray();

        $disponibilidad = array_map(function($horario) use ($reservas) {
            return [
                'hora' => $horario,
                'disponible' => !in_array($horario, $reservas)
            ];
        }, $horarios);

        return response()->json($disponibilidad);
    }

    public function listarReservas(Request $request)
    {
        $user = Auth::user();

        if ($user->is_admin != 1) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para ver esta página.');
        }

        $dni = $request->input('dni');
        $fecha = $request->input('fecha');

        $reservas = Reserva::query();

        if ($dni) {
            $usuario = User::where('dni', $dni)->first();
            if ($usuario) {
                $reservas = $reservas->where('user_id', $usuario->id);
            } else {
                $reservas = collect();
            }
        }

        if ($fecha) {
            $reservas = $reservas->where('fecha', $fecha);
        }

        $reservas = $reservas->get();

        return view('reservas.index', compact('reservas', 'user', 'dni', 'fecha'));
    }

    public function destroy($id, Request $request)
    {
        $user = $request->user();

        if ($user->is_admin != 1) {
            return redirect()->route('reservas.index')->with('error', 'No tienes permisos para realizar esta acción.');
        }

        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva finalizada exitosamente.');
    }

    // App\Http\Controllers\ReservaController.php

public function listarReservasUsuario()
{
    $user = Auth::user();
    $reservas = Reserva::with('cancha')
                ->where('user_id', $user->id)
                ->orderBy('fecha')
                ->get()
                ->groupBy('fecha');

    return view('reservas.usuario', compact('reservas'));
}

}
