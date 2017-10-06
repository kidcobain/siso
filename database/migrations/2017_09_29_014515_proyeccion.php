<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Proyeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('proyeccion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->string('g95');
            $table->string('g91');
            $table->string('dsl');
            $table->integer('lote_id')->unsigned();

            $table->foreign('lote_id')->references('id')->on('lote')->onDelete('cascade')->onUpdate('cascade');
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
