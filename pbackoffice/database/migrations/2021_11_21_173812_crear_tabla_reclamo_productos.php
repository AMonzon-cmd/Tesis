<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaReclamoProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RelProductoUsuario', function (Blueprint $table) {
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('producto_id');
            $table->unsignedMediumInteger('puntos_usuario');
            $table->unsignedMediumInteger('puntos_producto');
            $table->timestamps();

            $table->primary(['usuario_id', 'producto_id'], 'PK_usuario_producto');
            $table->foreign('usuario_id', 'FK_usuario_reclama')->references('id')->on('Usuarios')->onDelete('restrict');
            $table->foreign('producto_id', 'FK_producto_reclama')->references('id')->on('ProductosCatalogo')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RelProductoUsuario');
    }
}
