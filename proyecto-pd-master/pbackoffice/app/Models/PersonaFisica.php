<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaFisica extends Model
{

    protected $table = 'PersonasFisicas';
    protected $primaryKey = 'IdPersonaFisica';

    protected $fillable = [
        'IdUsuario', 'Nombre', 'Apellido', 'Documento', 'Sexo', 'FechaNacimiento'
    ];

}
