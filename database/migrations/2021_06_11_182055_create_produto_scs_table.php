<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoScsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_scs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('nome');
            $table->string('descricao', 500);
            $table->integer('quantidade');
            $table->integer('preco');
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
        Schema::dropIfExists('produto_scs');
    }
}
