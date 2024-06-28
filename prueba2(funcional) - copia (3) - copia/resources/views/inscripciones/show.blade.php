<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-white text-4xl font-bold mb-8 text-center">Detalles de la Clase</h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-2 text-black">{{ $clase->categoria }}</h2>
            <p class="text-black"><span class="font-semibold">Instructor:</span> {{ $clase->instructor }}</p>
            <p class="text-black"><span class="font-semibold">Cupos Totales:</span> {{ $clase->cupos_totales }}</p>
            <p class="text-black"><span class="font-semibold">Duración:</span> {{ $clase->duracion }} minutos</p>
            <p class="text-black"><span class="font-semibold">Fecha de Inicio:</span> {{ $clase->fecha_inicio }}</p>
            <p class="text-black"><span class="font-semibold">Hora de Inicio:</span> {{ $clase->hora_inicio }}</p>
            <p class="text-black"><span class="font-semibold">Hora de Fin:</span> {{ $clase->hora_fin }}</p>
            <p class="text-black"><span class="font-semibold">Costo de Inscripción:</span> s/.{{ $clase->costo_inscripcion }}</p>
            <p class="mt-4 text-black">{{ $clase->informacion }}</p>

            @if ($hayCuposDisponibles)
                <form action="{{ route('inscripciones.inscribir', $clase) }}" method="POST">
                    @csrf
                    <button class="bg-gray-800 text-white font-bold py-2 px-4 rounded mt-4 hover:bg-gray-600">
                        Confirmar Inscripción
                    </button>
                </form>
            @else
                <p class="text-red-500 mt-4">Ya no hay cupos disponibles.</p>
                <button class="bg-gray-400 text-white font-bold py-2 px-4 rounded mt-4 cursor-not-allowed" disabled>
                    Inscripción Cerrada
                </button>
            @endif
        </div>
    </div>
</x-app-layout>

