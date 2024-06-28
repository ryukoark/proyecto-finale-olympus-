<x-app-layout>
    <head>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap">
        <style>
            .custom-heading {
                font-family: 'Roboto', sans-serif;
                font-weight: bold;
                font-size: 100px;
                color: #FFFFFF; /* Letra blanca */
                text-shadow: 
                    -1px -1px 0 #000000,  
                    1px -1px 0 #000000,
                    -1px 1px 0 #000000,
                    1px 1px 0 #000000; /* Contorno negro */
            }
            .horario-btn {
                font-family: 'Roboto', sans-serif;
                font-weight: bold;
                padding: 10px 20px;
                margin: 5px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            .horario-btn.disponible {
                background-color: #739505;
                color: #000000;
            }
            .horario-btn.seleccionado {
                background-color: #4CAF50;
                color: #FFFFFF;
            }
            .horario-btn.no-disponible {
                background-color: #a91106;
                color: #000000;
                cursor: not-allowed;
            }
            .horario-btn.disponible:hover {
                background-color: #739505;
            }
            #horarios {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 20px;
            }
            #fecha {
                padding: 10px;
                border: 2px solid #000000;
                border-radius: 5px;
                font-size: 16px;
                margin-top: 20px;
                color: #000000; /* Añadido para hacer el texto de fecha negro */
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            let horariosSeleccionados = [];

            function mostrarHorarios(canchaId) {
                const fecha = document.getElementById('fecha').value;
                if (fecha) {
                    fetch(`/getHorarios/${canchaId}?fecha=${fecha}`)
                        .then(response => response.json())
                        .then(data => {
                            const horariosDiv = document.getElementById('horarios');
                            horariosDiv.innerHTML = '';
                            data.forEach(horario => {
                                const btn = document.createElement('button');
                                btn.textContent = horario.hora;
                                btn.className = 'horario-btn';
                                if (horario.disponible) {
                                    btn.classList.add('disponible');
                                    btn.onclick = () => seleccionarHorario(btn, horario.hora);
                                } else {
                                    btn.classList.add('no-disponible');
                                    btn.disabled = true;
                                }
                                horariosDiv.appendChild(btn);
                            });
                        });
                }
            }

            function seleccionarHorario(button, horario) {
                if (horariosSeleccionados.includes(horario)) {
                    horariosSeleccionados = horariosSeleccionados.filter(h => h !== horario);
                    button.classList.remove('seleccionado');
                } else {
                    horariosSeleccionados.push(horario);
                    button.classList.add('seleccionado');
                }
                console.log(horariosSeleccionados);
            }

            function irAResumen(canchaId) {
                const fecha = document.getElementById('fecha').value;
                if (fecha && horariosSeleccionados.length > 0) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/resumen';
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                        <input type="hidden" name="fecha" value="${fecha}">
                        <input type="hidden" name="cancha" value="${canchaId}"> <!-- Añadir la cancha aquí -->
                        ${horariosSeleccionados.map(h => `<input type="hidden" name="horarios[]" value="${h}">`).join('')}
                    `;
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    alert('Por favor, selecciona una fecha y al menos un horario.');
                }
            }
        </script>
    </head>
    <div class="relative min-h-screen flex flex-col justify-center items-start text-left px-10 bg-cover bg-center bg-no-repeat" style="background-image: url('/images/background.png');">
        <div class="mt-16">
            <h1 class="custom-heading">Reservar Horario</h1>
            <input type="date" id="fecha" onchange="mostrarHorarios({{ $cancha->id }})">
            <div id="horarios"></div>
            <button onclick="irAResumen({{ $cancha->id }})" class="horario-btn disponible">reservar</button>
        </div>
    </div>
</x-app-layout>

