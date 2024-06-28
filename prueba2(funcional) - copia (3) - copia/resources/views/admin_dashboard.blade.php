<!-- resources/views/admin_dashboard.blade.php -->
<x-app-layout>
    @if(Auth::user()->is_admin === 1)
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-4xl font-bold mb-8 text-center">Panel de Administración</h1>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <ul>
                    <li class="mb-4">
                        <a href="{{ url('/clases') }}" class="text-blue-500 hover:text-blue-700 font-semibold">Gestión de clases</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ url('/reservas') }}" class="text-blue-500 hover:text-blue-700 font-semibold">Gestión de reservas</a>
                    </li>
                </ul>
            </div>
        </div>
    @else
        <script>window.location = "/dashboard";</script>
    @endif
</x-app-layout>
