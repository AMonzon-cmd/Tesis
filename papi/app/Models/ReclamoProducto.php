<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReclamoProducto extends Model
{
    use HasFactory;

    protected $table = 'RelProductoUsuario';
    protected $primaryKey = 'usuario_id';

    protected $fillable = [
        'usuario_id', 'producto_id', 'puntos_usuario', 'puntos_producto'
    ];
}
