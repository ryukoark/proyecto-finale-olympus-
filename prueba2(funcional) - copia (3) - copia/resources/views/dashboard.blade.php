<x-app-layout>
    <head>
        <!-- Incluir la fuente Roboto desde Google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap">
        <style>
            .custom-heading {
                font-family: 'Roboto', sans-serif;
                font-weight: bold;
                font-size: 100px;
                color: #FFFFFF; /* Letra blanca */
            }
            .welcome-message {
                font-size: 24px; /* Aumentar el tamaño de la fuente del párrafo de bienvenida */
                margin-top: 10px; /* Ajustar el margen superior */
            }
            .centered-content {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        </style>
    </head>
    <div class="relative min-h-screen flex flex-col justify-center items-center text-center px-10 bg-cover bg-center bg-no-repeat" style="background-image: url('/images/background.png');">
        <div class="centered-content mt-0"> <!-- Ajustar el margen superior -->
            <h1 class="custom-heading">OLYMPUS <br>
            TENNIS CAMP</h1>
            <p class="welcome-message" style="text-align: left; width: 100%;">Bienvenido, {{ Auth::user()->name }}</p> <!-- Agregar mensaje de bienvenida -->
        </div>
    </div>
</x-app-layout>
