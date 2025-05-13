<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokemonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id();
            $table->string('nome');           // nome do Pokémon
            $table->string('tipo');           // tipo (ex: fogo, água)
            $table->string('habilidades');    // habilidades principais
            $table->float('altura');          // altura em metros
            $table->float('peso');            // peso em kg
            $table->string('imagem')->nullable(); // URL da imagem
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokemons');
    }
}
