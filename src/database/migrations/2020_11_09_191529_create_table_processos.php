<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProcessos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processoSeletivo', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status');
            $table->string('nomeProcesso');
            $table->date('dataInicio');
            $table->date('dataFim');
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
        Schema::dropIfExists('processoSeletivo');
    }
}
