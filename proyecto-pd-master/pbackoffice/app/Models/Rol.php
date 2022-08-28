<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rol extends Model
{
    protected $table = 'Role';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre'
    ];

    public function ListarPermisos(){
        return DB::table('Permisos')->join('PermisosDeRoles', 'PermisosDeRoles.permiso_id', '=', 'Permisos.id')->join('Role', 'Role.id', '=', 'PermisosDeRoles.rol_id')->where('Role.id', $this->IdRol)->pluck('Permisos.nombre');
    }
}
