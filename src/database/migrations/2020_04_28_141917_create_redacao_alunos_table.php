<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedacaoAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redacao_alunos', function (Blueprint $table) {
            $table->id();
            $table->longText('redacao');

            $table->unsignedBigInteger('inscrito_id');
            $table->foreign('inscrito_id')->references('id')->on('inscritos')->onDelete('cascade');

            $table->unsignedBigInteger('redacao_id');
            $table->foreign('redacao_id')->references('id')->on('redacaos')->onDelete('cascade');

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
        Schema::dropIfExists('redacao_alunos');
    }
}
