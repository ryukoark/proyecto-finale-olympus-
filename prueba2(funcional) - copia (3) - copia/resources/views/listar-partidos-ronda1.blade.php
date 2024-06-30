<!-- resources/views/listar-partidos-ronda1.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partidos Ronda 1</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Partidos Ronda 1</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Partido</th>
                    <th>Jugador 1</th>
                    <th>Jugador 2</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partidos as $nroPartido => $grupoPartidos)
                    @php
                        $jugador1 = $grupoPartidos[0]->nombre_jugador1;
                        $jugador2 = isset($grupoPartidos[1]) ? $grupoPartidos[1]->nombre_jugador1 : 'Pendiente';
                    @endphp
                    <tr>
                        <td>Partido {{ $nroPartido }}</td>
                        <td>{{ $jugador1 }}</td>
                        <td>{{ $jugador2 }}</td>
                        <td>
                            <a href="{{ route('mostrarSubirResultadoRonda2', ['idTorneo' => $grupoPartidos[0]->id_torneo, 'nroPartido' => $nroPartido]) }}" class="btn btn-primary">Subir Resultado Ronda 1</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
