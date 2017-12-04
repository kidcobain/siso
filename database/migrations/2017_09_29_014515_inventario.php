<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Inventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('inventario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->string('g95');
            $table->string('g91');
            $table->string('dsl');
            $table->integer('proyeccion_id')->unsigned();
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
