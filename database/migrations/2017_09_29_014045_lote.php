<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Lote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('lote', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero');
            $table->string('tipo');
            $table->date('fecha_entrada')->nullable();
            $table->date('hora')->nullable();
            $table->integer('proyeccion_id')->unsigned();
            //$table->datetime('fecha_salida')->nullable();
            $table->timestamps();
            $table->softDeletes();  //deleted_at

            $table->foreign('proyeccion_id')->references('id')->on('proyeccion')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
