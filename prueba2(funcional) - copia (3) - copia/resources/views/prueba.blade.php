<!DOCTYPE html>
<html>
<head>
    <title>Vista de Torneo</title>
    <style>
        .tournament {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .round {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
            width: 80%;
        }
        .round-title {
            font-weight: bold;
            font-size: 1.2em;
            text-align: center;
            margin-bottom: 10px;
        }
        .matches {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .match {
            border: 1px solid #000;
            padding: 10px;
            margin: 5px;
            width: 45%;
            text-align: center;
            position: relative;
        }
        .upload-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="tournament">
        <div class="round">
            <div class="round-title">Ronda 1</div>
            <div class="matches">
                @for ($i = 1; $i <= 8; $i++)
                    <div class="match">
                        Partido {{ $i }}
                        <button class="upload-button">Subir info del partido</button>
                    </div>
                @endfor
            </div>
        </div>
        
        <div class="round">
            <div class="round-title">Ronda 2</div>
            <div class="matches">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="match">
                        Partido {{ $i }}
                        <button class="upload-button">Subir info del partido</button>
                    </div>
                @endfor
            </div>
        </div>
        
        <div class="round">
            <div class="round-title">Ronda 3</div>
            <div class="matches">
                @for ($i = 1; $i <= 2; $i++)
                    <div class="match">
                        Partido {{ $i }}
                        <button class="upload-button">Subir info del partido</button>
                    </div>
                @endfor
            </div>
        </div>
        
        <div class="round">
            <div class="round-title">Ronda 4</div>
            <div class="matches">
                <div class="match">
                    Partido 1
                    <button class="upload-button">Subir info del partido</button>
                </div>
            </div>
        </div>
        
        <div class="round">
            <div class="round-title">Ronda 5</div>
            <div class="matches">
                <div class="match">
                    Ganador
                    <button class="upload-button">Subir info del partido</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

