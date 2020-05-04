<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRedacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redacao_alunos', function (Blueprint $table) {
            $table->renameColumn('redacao', 'redacao_aluno');
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
            $table->renameColumn('redacao_aluno', 'redacao');
        });
    }
}
