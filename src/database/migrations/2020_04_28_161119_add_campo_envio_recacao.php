<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoEnvioRecacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redacao_alunos', function (Blueprint $table) {
            $table->boolean('enviou_redacao')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redacao_alunos', function (Blueprint $table) {
            $table->boolean('enviou_redacao')->default(0);
        });
    }
}
