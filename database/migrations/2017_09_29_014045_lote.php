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
            //$table->datetime('fecha_entrada')->nullable();
            //$table->datetime('fecha_salida')->nullable();
            $table->timestamps();
            $table->softDeletes();  //deleted_at
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
