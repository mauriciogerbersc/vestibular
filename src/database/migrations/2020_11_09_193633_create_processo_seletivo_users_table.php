<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessoSeletivoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo_seletivo_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('inscrito_id');
            $table->foreign('inscrito_id')->references('id')->on('inscritos')->onDelete('cascade');

            $table->unsignedBigInteger('processo_id');
            $table->foreign('processo_id')->references('id')->on('processoSeletivo')->onDelete('cascade');


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
        Schema::dropIfExists('processo_seletivo_users');
    }
}
