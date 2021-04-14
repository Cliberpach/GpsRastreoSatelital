<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clienteapp', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->id();
            $table->mediumText('nombre');
            $table->string('telefono');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('clienteapp');
    }
}
