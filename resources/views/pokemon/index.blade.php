<!DOCTYPE html>
<html>
<head>
    <title>Pokémons</title>
    <style>


    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
    .pagination > * {
        padding: 0.5rem 0.75rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
    }

        body { font-family: Arial; }
        .pokemon-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            text-align: center;
        }
        img {
            width: 120px;
            height: 120px;
        }
        a {
            text-decoration: none;
            color: #333;
        }
        a:hover {
            text-decoration: underline;
        }
        .button {
            display: inline-block;
            padding: 5px 10px;
            margin-top: 8px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Lista de Pokémons</h1>

    @foreach ($pokemons as $pokemon)
        <div class="pokemon-card">
            <h3>
                <a href="{{ url('/pokemons/' . $pokemon->id) }}">
                    {{ ucfirst($pokemon->nome) }}
                </a>
            </h3>
            <img src="{{ $pokemon->imagem }}" alt="{{ $pokemon->nome }}">
            <p><strong>Tipo:</strong> {{ $pokemon->tipo }}</p>
            <p><strong>Altura:</strong> {{ $pokemon->altura }}</p>
            <p><strong>Peso:</strong> {{ $pokemon->peso }}</p>
            <a class="button" href="{{ url('/pokemons/' . $pokemon->id) }}">Ver mais</a>
        </div>
    @endforeach

    <div class="pagination">
    {{ $pokemons->links() }}
</div>
</body>
</html>
