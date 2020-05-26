<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Curso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso', function (Blueprint $table) {
            $table->id();
            $table->string('curso');
            $table->tinyInteger('status')->default('1');
            $table->longText('descricao')->nullable();
            $table->string('imagem_curso')->nullable();
            $table->string('slug');
            $table->string('tipo_curso');
            $table->string('link_curso')->nullable();
            $table->string('banner_curso')->nullable();
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
        Schema::table('curso', function (Blueprint $table) {
            Schema::dropIfExists('curso');
        });
    }
}
