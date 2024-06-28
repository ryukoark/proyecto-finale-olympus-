<x-app-layout>
    <div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-black">Resumen de la Reserva</h1>
        <p class="mb-2 text-black"><strong>Fecha:</strong> {{ $fecha }}</p>
        <p class="mb-2 text-black"><strong>Horarios:</strong> {{ implode(', ', $horarios) }}</p>
        <p class="mb-4 text-black"><strong>Monto a Pagar:</strong> s/.{{ $monto }}</p>
        <form method="POST" action="{{ route('reservas.store', ['cancha' => $canchaId]) }}">
            @csrf
            <input type="hidden" name="fecha" value="{{ $fecha }}">
            <input type="hidden" name="cancha" value="{{ $canchaId }}">
            @foreach ($horarios as $horario)
                <input type="hidden" name="horarios[]" value="{{ $horario }}">
            @endforeach
            <button type="submit" class="bg-green-600 text-white font-bold py-2 px-4 rounded hover:bg-green-700">Confirmar Reserva</button>
        </form>
    </div>
</x-app-layout>

