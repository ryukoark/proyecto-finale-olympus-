<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use App\Models\Torneo;
use App\Models\InscribirseTorneo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartidoController extends Controller
{
    public function ejecutarRonda1($idTorneo)
    {
        // Obtener los participantes del torneo
        $participantes = InscribirseTorneo::where('id_torneo', $idTorneo)->get();
        $numParticipantes = $participantes->count();

        // Inicializar variables
        $partidos = [];
        $numPartidos = 8;
        $partidosPorRonda = array_fill(0, $numPartidos, 0); // Array para contar partidos asignados por número

        // Calcular el número de partidos vacíos necesarios
        $numPartidosVacios = 16 - intval(($numParticipantes + 1) / 2) * 2;

        // Crear partidos con los participantes disponibles
        for ($i = 0; $i < $numParticipantes; $i++) {
            do {
                $nroPartido = rand(1, intval(($numParticipantes + 1) / 2));
            } while ($partidosPorRonda[$nroPartido - 1] >= 2);

            $partidosPorRonda[$nroPartido - 1]++;

            $partidos[] = [
                'id_torneo' => $idTorneo,
                'ronda' => 1,
                'nro_partido' => $nroPartido,
                'jugador1' => $participantes[$i]->id_inscripciontorneo,
                'nombre_jugador1' => $participantes[$i]->nombre_usuario,
                'jugador2' => null,
                'nombre_jugador2' => '',
                'cancha' => null,
                'fecha' => null,
                'ganador' => null,
                'puntaje' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Crear partidos vacíos y asignarles los números de partido restantes
        $numeroPartido = $numPartidos;
        while ($numPartidosVacios > 0) {
            $partidos[] = [
                'id_torneo' => $idTorneo,
                'ronda' => 1,
                'nro_partido' => $numeroPartido,
                'jugador1' => null,
                'nombre_jugador1' => '',
                'jugador2' => null,
                'nombre_jugador2' => '',
                'cancha' => null,
                'fecha' => null,
                'ganador' => null,
                'puntaje' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $numPartidosVacios--;
            if ($numPartidosVacios > 0) {
                $partidos[] = [
                    'id_torneo' => $idTorneo,
                    'ronda' => 1,
                    'nro_partido' => $numeroPartido,
                    'jugador1' => null,
                    'nombre_jugador1' => '',
                    'jugador2' => null,
                    'nombre_jugador2' => '',
                    'cancha' => null,
                    'fecha' => null,
                    'ganador' => null,
                    'puntaje' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $numPartidosVacios--;
            }
            $numeroPartido--;
        }

        // Insertar los partidos en la base de datos
        Partido::insert($partidos);

        return response()->json(['message' => 'Ronda 1 generada exitosamente.'], 200);
    }

    public function mostrarVistaRonda1($idTorneo)
    {
        return view('asignar-ronda1', ['idTorneo' => $idTorneo]);
    }

    public function listarPartidosRonda1($idTorneo)
    {
        $partidos = Partido::where('id_torneo', $idTorneo)
            ->where('ronda', 1)
            ->orderBy('nro_partido')
            ->get()
            ->groupBy('nro_partido');

        return view('listar-partidos-ronda1', compact('partidos'));
    }


    public function mostrarSubirResultadoRonda2($idTorneo, $nroPartido)
    {
        $partidos = Partido::where('id_torneo', $idTorneo)
            ->where('nro_partido', $nroPartido)
            ->where('ronda', 1)
            ->get();

        return view('subir-resultado-ronda2', compact('partidos', 'nroPartido', 'idTorneo'));
    }

    public function subirResultadoRonda2(Request $request, $idTorneo, $nroPartido)
    {
        $validated = $request->validate([
            'cancha' => 'required|string',
            'fecha' => 'required|date',
            'ganador' => 'required|exists:inscribirse_torneo,id_inscripciontorneo',
            'puntaje' => 'required|string',
        ]);

        $partidosRonda1 = Partido::where('id_torneo', $idTorneo)
            ->where('nro_partido', $nroPartido)
            ->where('ronda', 1)
            ->get();

        if ($partidosRonda1->count() == 2) {
            $partido1 = $partidosRonda1[0];
            $partido2 = $partidosRonda1[1];

            Partido::create([
                'id_torneo' => $idTorneo,
                'ronda' => 2,
                'nro_partido' => $nroPartido,
                'jugador1' => $partido1->jugador1,
                'nombre_jugador1' => $partido1->nombre_jugador1,
                'jugador2' => $partido2->jugador1,
                'nombre_jugador2' => $partido2->nombre_jugador1,
                'cancha' => $validated['cancha'],
                'fecha' => $validated['fecha'],
                'ganador' => $validated['ganador'],
                'puntaje' => $validated['puntaje'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('listarPartidosRonda1', $idTorneo)->with('success', 'Resultado de la ronda 2 subido exitosamente.');
        }

        return redirect()->route('listarPartidosRonda1', $idTorneo)->with('error', 'No se encontraron suficientes datos para la ronda 2.');
    }
}
