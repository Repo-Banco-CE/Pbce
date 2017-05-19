<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacturasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuenta_id')->unsigned();
            $table->integer('factura_id')->unsigned();
            $table->timestamps();

            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');
            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas_users');
    }
}
