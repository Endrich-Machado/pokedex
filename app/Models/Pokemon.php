<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemons'; // <-- Corrige o nome da tabela!

    protected $fillable = ['nome', 'tipo', 'habilidades', 'altura', 'peso', 'imagem'];
}
