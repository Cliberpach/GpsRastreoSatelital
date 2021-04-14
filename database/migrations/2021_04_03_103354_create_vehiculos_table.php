<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->string('placa');
            $table->string('marca');
            $table->string('color');
            $table->string('dnidueño');
            $table->string('nombredueño');
            $table->string('activodni')->default('SIN VERIFICAR');
            $table->enum('estadovehiculo',['VIGENTE','BAJA'])->default('VIGENTE');
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
        Schema::dropIfExists('vehiculos');
    }
}
