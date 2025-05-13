<!DOCTYPE html>
<html>
<head>
    <title>{{ $pokemon->nome }}</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 2rem; }
        img { max-width: 300px; }
        .card {
            display: inline-block;
            padding: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 1rem;
            background-color: #f8f8f8;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
        }
        .back-button {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.5rem 1rem;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 1rem;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>{{ ucfirst($pokemon->nome) }}</h1>
        <img src="{{ $pokemon->imagem }}" alt="{{ $pokemon->nome }}">
        <p><strong>Tipo:</strong> {{ $pokemon->tipo }}</p>
        <p><strong>Habilidades:</strong> {{ $pokemon->habilidades }}</p>
        <p><strong>Altura:</strong> {{ $pokemon->altura }}</p>
        <p><strong>Peso:</strong> {{ $pokemon->peso }}</p>
    </div>

    <div>
        <a href="{{ url('/pokemons') }}" class="back-button">← Voltar para lista</a>
    </div>
</body>
</html>
