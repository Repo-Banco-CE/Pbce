<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fecha_emision');
            $table->string('fecha_vencimiento');
            $table->integer('monto');
            $table->string('estado');
            $table->string('rif_distribuidor');
            $table->string('rif_comercio');
            $table->string('nombre_comercio');
            $table->string('ref_factura');
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
        Schema::dropIfExists('facturas');
    }
}
