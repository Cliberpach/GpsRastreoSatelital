<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarreraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrera', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->id();
            $table->string("conductor_id");
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->mediumText('referencia');
            $table->string("direccionInicial");
            $table->string("latinicial");
            $table->string("latfinal");
            $table->string("lnginicial");
            $table->string("lngfinal");
            $table->string("direccionFinal");
            $table->string("hora");
            $table->string("importe")->nullable();
            $table->enum('estadocarrera',['TERMINADA','PROCESO','ANULADA'])->default('PROCESO');
            $table->enum('estado',['ACTIVO','ANULADO'])->default('ACTIVO');
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
        Schema::dropIfExists('carrera');
    }
}
