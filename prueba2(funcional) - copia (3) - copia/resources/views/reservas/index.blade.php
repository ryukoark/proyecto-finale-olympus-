<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="text-white text-4xl font-bold mb-8 text-center">Listado de Reservas</h1>

        @if ($user->is_admin == 1)
            <form action="{{ route('reservas.index') }}" method="GET" class="mb-4">
                <div class="flex justify-center">
                    <input type="text" name="dni" placeholder="Buscar por DNI" value="{{ old('dni', $dni) }}" class="px-4 py-2 border rounded-l-lg focus:outline-none text-black">
                    <input type="date" name="fecha" placeholder="Buscar por Fecha" value="{{ old('fecha', $fecha) }}" class="px-4 py-2 border rounded-l-lg focus:outline-none text-black ml-2">
                    <button type="submit" class="px-4 py-2 text-white rounded-r-lg" style="background-color: #739505;">Buscar</button>
                </div>
            </form>

            <table class="table-auto w-full text-white">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Cancha</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Horario</th>
                        <th class="px-4 py-2">Usuario</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservas as $reserva)
                        <tr class="bg-gray-800">
                            <td class="border px-4 py-2">{{ $reserva->cancha->nombre }}</td>
                            <td class="border px-4 py-2">{{ $reserva->fecha }}</td>
                            <td class="border px-4 py-2">{{ $reserva->horario }}</td>
                            <td class="border px-4 py-2">{{ $reserva->user->name }}</td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg" onclick="return confirm('¿Estás seguro de que quieres finalizar esta reserva?')">Finalizar Reserva</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border px-4 py-2 text-center">No hay reservas disponibles</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <p class="text-center text-red-500">No tienes permisos para ver esta página.</p>
        @endif
    </div>
</x-app-layout>
