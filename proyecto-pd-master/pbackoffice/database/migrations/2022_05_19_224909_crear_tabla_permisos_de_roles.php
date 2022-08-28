<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPermisosDeRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisosDeRoles', function (Blueprint $table) {
            $table->unsignedTinyInteger('rol_id');
            $table->unsignedInteger('premiso_id');
            $table->timestamps();

            $table->primary(['rol_id', 'premiso_id']);
            $table->foreign('rol_id', 'FK_PermisoDeRol_Rol')->references('id')->on('Roles')->onDelete('restrict');
            $table->foreign('premiso_id', 'FK_PermisoDeRol_Permiso')->references('id')->on('Permisos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisosDeRoles');
    }
}
