<nav x-data="{ open: false, dropdownOpen: false }" class="bg-black text-white w-full p-5">
    <div class="flex items-center justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <!-- Left Side -->
        <div class="flex space-x-8">
            <a href="{{ route('reservas.usuario') }}" class="text-white font-semibold">Mis Reservas</a>
            <a href="{{ route('inscripciones.mis_clases') }}" class="text-white font-semibold">Mis Clases</a>
        </div>

        <!-- Center -->
        <div class="flex justify-center flex-grow">
            <a href="{{ route('dashboard') }}" class="w-full">
                <img src="{{ asset('images/logo.png') }}" alt="Olympus Tennis Camps" class="w-full h-10 object-contain">
            </a>
        </div>

        <!-- Right Side -->
        <div class="flex space-x-8 items-center">
            <a href="{{ route('seleccionarCancha') }}" class="text-white font-semibold">Seleccionar Cancha</a>
            <a href="{{ route('clases.list') }}" class="text-white font-semibold">Academia</a>

            <!-- Desktop Dropdown -->
            <div class="relative" @click.away="dropdownOpen = false">
                <button @click="dropdownOpen = ! dropdownOpen" class="text-white font-semibold">
                    {{ Auth::user()->name }}
                </button>
                <div x-show="dropdownOpen" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hamburger Button for Mobile View -->
        <div class="-me-2 flex items-center sm:hidden">
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black text-white w-full absolute top-16 right-0">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('reservas.usuario') }}" class="text-white font-semibold block px-3 py-2">Mis Reservas</a>
            <a href="{{ route('inscripciones.mis_clases') }}" class="text-white font-semibold block px-3 py-2">Mis Clases</a>
            <a href="{{ route('seleccionarCancha') }}" class="text-white font-semibold block px-3 py-2">Seleccionar Cancha</a>
            <a href="{{ route('clases.list') }}" class="text-white font-semibold block px-3 py-2">Academia</a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Profile</a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-gray-700">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>

