<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicacaos', function (Blueprint $table) {
            $table->id();
            $table->integer('cd_pessoa_unimestre')->comment('código da pessoa que indica no Unimestre');
            $table->string('hash')->comment('Hash gerada para indicação');
            $table->string('name_indicado');
            $table->string('email_indicado');
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
        Schema::dropIfExists('indicacaos');
    }
}
