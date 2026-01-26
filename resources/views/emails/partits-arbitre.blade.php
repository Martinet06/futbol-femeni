<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
        }

        .partit {
            background: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #3498db;
        }

        .data {
            color: #7f8c8d;
            font-weight: bold;
        }

        .equips {
            font-size: 18px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>⚽ Hola, {{ $arbitre->name }}!</h1>

        <p>Com a àrbitre de la Guia de Futbol Femení, tens assignats els següents partits:</p>

        @forelse($partits as $partit)
        <div class="partit">
            <div class="data">
                📅 {{ \Carbon\Carbon::parse($partit->data_partit)->format('d/m/Y') }}
                @if($partit->jornada)
                | Jornada {{ $partit->jornada }}
                @endif
            </div>
            <div class="equips">
                {{ $partit->equipLocal->nom }} vs {{ $partit->equipVisitant->nom }}
            </div>
            @if($partit->gols_local !== null)
            <div>
                Resultat: {{ $partit->gols_local }} - {{ $partit->gols_visitant }}
            </div>
            @endif
        </div>
        @empty
        <p>No tens cap partit assignat actualment.</p>
        @endforelse

        <div class="footer">
            <p>Gràcies per la teva col·laboració! ⚖️</p>
            <p><strong>Guia de Futbol Femení</strong></p>
        </div>
    </div>
</body>

</html>