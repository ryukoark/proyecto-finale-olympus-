<!DOCTYPE html>
<html>
<head>
    <title>Mis Reservas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Mis Reservas</h1>
    @if($reservas->isEmpty())
        <p>No tienes reservas.</p>
    @else
        @foreach($reservas as $fecha => $reservasPorFecha)
            <h2>Reservas para {{ $fecha }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cancha</th>
                        <th>Horario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservasPorFecha as $reserva)
                        <tr>
                            <td>{{ $reserva->cancha->nombre }}</td>
                            <td>{{ $reserva->horario }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        @endforeach
    @endif
</body>
</html>
