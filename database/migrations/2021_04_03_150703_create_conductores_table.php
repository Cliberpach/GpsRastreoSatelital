<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 
     */
    public function up()
    {
        Schema::create('conductores', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->mediumText('nombre');
            $table->string('tipo_documento');
            $table->string('documento',25);
            $table->string('direccion');
            $table->string('tipo_documento_contacto')->nullable();
            $table->string('documento_contacto')->nullable();
            $table->mediumText('nombre_contacto')->nullable();
            $table->string('telefono_movil');
            $table->string('correo_electronico');
            $table->string('imei');
            $table->string('activo')->default('SIN VERIFICAR');
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
        Schema::dropIfExists('conductores');
    }
}
